<?php

namespace touiteur\message;
require_once "vendor/autoload.php";

use touiteur\exception as ex;

class touite
{
    //contenu du touite
    protected string $contenu;

    //nom de l'auteur du touite
    protected string $nom;

    //prenom de l'auteur du touite
    protected string $prenom;

    //note du touite
    protected int $note;

    //date de publication du touite
    protected string $date;

    //tableau contenant les tags du touite
    protected array $tag;

    /**
     * @param string $nom nom de l'auteur
     * @param string $prenom prenom de l'auteur
     * @param string $cont contenu du touite
     * @param string $date date de publication du touite
     * @param int $note note du touite, 0 par défaut
     * constructeur de touite
     */
    public function __construct(string $nom, string $prenom, string $cont, string $date, int $note = 0)
    {
        //Le touite doit avoir un contenu inferrieur à 235 caractere
        if ($this->tailleTouite($cont) <= 235) {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->note = $note;
            $this->contenu = $cont;
            $this->date = $date;
            $this->tag = [];
            $this->tableauTag($cont);
        } else {
            echo ">:( le touite est trop long";
        }

    }

    /**
     * @param string $cont contenue d'un touite
     * @return int taille du touite
     */
    public function tailleTouite(string $cont)
    {
        return strlen($cont);
    }

    /**
     * Trouve les tags du touite et les ajoutes dans le tableau tag
     * @param string $cont contenu d'un touite
     * @return void
     */
    public function tableauTag(string $cont)
    {
        if (str_contains($cont, "#")) {

            //sépare le contenue en un tableau de string à partir des espaces
            $explode = explode(' ', $cont);

            foreach ($explode as $part) {
                if (str_starts_with($part, "#")) {
                    $this->tag[] = $part;
                }
            }

        }
    }

    /**
     * Methode magique get permetant de recupere les parametre proteger
     * @param string $at nom du parametre a recuperer
     * @return mixed type du parametre renvoye
     * @throws ex\InvalidePropety class d'exception sur les propiete invalide
     */
    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        } else {
            throw new ex\InvalidePropety("$at: invalide propety ");
        }
    }

}