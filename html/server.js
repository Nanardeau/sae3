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
app.use(cors({
  origin: "http://localhost:8888", // Lien du serveur php
  methods: ["GET", "POST", "PUT"],
  allowedHeaders: ["Content-Type"]
}));

// Connexion à la BDD
const pool = new Pool({
  user: process.env.PGUSER,
  host: process.env.PGHOST,
  database: process.env.PGDATABASE,
  password: process.env.PGPASSWORD,
  port: process.env.PGPORT,
});
//Ajouter les lien de l'API -> gérer les quantités. 
    // test de connexion avec la bdd
    app.get("/", async(req,res) =>{

    })
app.put("/update-plus/:idPanier/:idProd", (req , res) => {
    const idPanier = req.params.idPanier;
    const idProd = req.params.idProd;
    
    const update_query = 'UPDATE alizon.ProdUnitPanier SET qteProd = qteProd + 1 WHERE idPanier = $1 AND codeProduit = $2 RETURNING qteProd';

    pool.query(update_query, [idPanier, idProd], (err, result) => {
        if (err) {
            console.error(err);
            return res.status(500).send('Erreur base de données');
        }
        if (!result.rows || result.rows.length === 0) {
            return res.status(404).send('Produit ou panier introuvable');
        }
        return res.json({ qte: result.rows[0].qteprod });
    });
})
app.put("/update-moins/:idPanier/:idProd", (req , res) => {

    /*TODO :
        -Faire la vérification de si la quantité = 1-> devient une suppression 
    */

    const idPanier = req.params.idPanier;
    const idProd = req.params.idProd;
    // Decrement but don't go below 0 and return new quantity
    const update_query = 'UPDATE alizon.ProdUnitPanier SET qteProd = GREATEST(qteProd - 1, 0) WHERE idPanier = $1 AND codeProduit = $2 RETURNING qteProd';

    pool.query(update_query, [idPanier, idProd], (err, result) => {
        if (err) {
            console.error(err);
            return res.status(500).send('Erreur base de données');
        }
        if (!result.rows || result.rows.length === 0) {
            return res.status(404).send('Produit ou panier introuvable');
        }
        return res.json({ qte: result.rows[0].qteprod });
    });
})
app.put("/supprime/:id/:idProd", (req, res) =>{
    const idPanier = req.params.idPanier;
    const idProd = req.params.idProd;
    const supp_querry = 'delete from ProdUnitPanier where idPanier = $1 and codeProduit = $2 RETURNING codeProduit  ';

    pool.query(supp_querry,[idPanier,idProd],(err,result)=>{
        if(err){
            console.error(err);
            return res.status(500).send('Erreur base de données');
        }
        if(!result.rows || result.rows.length === 0){
            return res.status(404).send('Produit ou panier introuvable');
        }
        return res.json({ prd: result.rows[0].codeProduit})
    })
})
app.listen(PORT, () => {
  console.log(`✅ Serveur Node lancé sur http://localhost:${PORT}`);
});


