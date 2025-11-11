import express from "express";
import cors from "cors";
import pkg from "pg";
import dotenv from "dotenv";


dotenv.config(); //Chargement du fichier .env
const { Pool } = pkg;

const app = express();
const PORT = 3000;

app.use(cors());
app.use(express.json());
// Lien avec le serveur php
app.use(
  cors({
    origin: "http://localhost:8888", // Lien du serveur php
    methods: ["GET", "POST", "PUT"],
    allowedHeaders: ["Content-Type"],
  })
);

// Connexion à la BDD
const pool = new Pool({
  user: process.env.PGUSER,
  host: process.env.PGHOST,
  database: process.env.PGDATABASE,
  password: process.env.PGPASSWORD,
  port: process.env.PGPORT,
});
//Ajouter les lien de l'API -> gérer les quantités / les paniers .
// test de connexion avec la bdd
app.get("/", async (req, res) => {});
app.put("/update-plus/:idPanier/:idProd", (req, res) => {
  const idPanier = req.params.idPanier;
  const idProd = req.params.idProd;

  const update_query =
    "UPDATE alizon.ProdUnitPanier SET qteProd = qteProd + 1 WHERE idPanier = $1 AND codeProduit = $2 RETURNING qteProd";

  pool.query(update_query, [idPanier, idProd], (err, result) => {
    if (err) {
      console.error(err);
      return res.status(500).send("Erreur base de données");
    }
    if (!result.rows || result.rows.length === 0) {
      return res.status(404).send("Produit ou panier introuvable");
    }
    return res.json({ qte: result.rows[0].qteprod });
  });
});

app.put("/update-moins/:idPanier/:idProd", (req, res) => {
  const idPanier = req.params.idPanier;
  const idProd = req.params.idProd;
  // Decrement but don't go below 0 and return new quantity
  const update_query =
    "UPDATE alizon.ProdUnitPanier SET qteProd = GREATEST(qteProd - 1, 0) WHERE idPanier = $1 AND codeProduit = $2 RETURNING qteProd";

  pool.query(update_query, [idPanier, idProd], (err, result) => {
    if (err) {
      console.error(err);
      return res.status(500).send("Erreur base de données");
    }
    if (!result.rows || result.rows.length === 0) {
      return res.status(404).send("Produit ou panier introuvable");
    }
    return res.json({ qte: result.rows[0].qteprod });
  });
});

app.put("/supprimer/:idPanier/:idProd", (req, res) => {
  const idPanier = req.params.idPanier;
  const idProd = req.params.idProd;
  const supp_querry =
    "delete from alizon.ProdUnitPanier where idPanier = $1 and codeProduit = $2 RETURNING codeProduit  ";

  pool.query(supp_querry, [idPanier, idProd], (err, result) => {
    if (err) {
      console.error(err);
      return res.status(500).send("Erreur base de données");
    }
    if (!result.rows || result.rows.length === 0) {
      return res
        .status(404)
        .send(`Produit ou panier introuvable ${idPanier} / ${idProd}`);
    }
    return res.json({ prd: result.rows[0].codeProduit });
  });
});

app.put("/supprimerPanier/:idPanier", async (req, res) => {
  const idPanier = req.params.idPanier;

  const suppProd_query = "delete from alizon.ProdUnitPanier where idPanier = $1 RETURNING idPanier";
  const suppPanier_query = "delete from alizon.Panier where idPanier = $1 RETURNING idPanier ";
  // Suppression de toutes les tables qui sont associer au panier à supprimer
  const client = await pool.connect();
  try {
    await client.query("BEGIN");

    // suppression des produits du panier. -> éviter les problèmes de clef étrangères
    const prodResult = await client.query(suppProd_query, [idPanier]);
    if (!prodResult.rows || prodResult.rows.length === 0) {
      await client.query("ROLLBACK");
      return res.status(404).send("Produit ou panier introuvable");
    }

    // Supprimer le panier en entier
    const panierResult = await client.query(suppPanier_query, [idPanier]);
    if (!panierResult.rows || panierResult.rows.length === 0) {
      await client.query("ROLLBACK");
      return res.status(404).send("Produit ou panier introuvable");
    }

    await client.query("COMMIT");
    // Renvoie une seul réponse
    return res.json({ PanierSupp: idPanier });
  } catch (err) {
    try {
      await client.query("ROLLBACK");
    } catch (rollbackErr) {
      console.error("Erreur du Rollback:", rollbackErr);
    }
    console.error(err);
    return res.status(500).send("Erreur base de données");
  } finally {
    client.release();
  }
});
app.listen(PORT, () => {
  console.log(`✅ Serveur Node lancé sur http://localhost:${PORT}`);
});
