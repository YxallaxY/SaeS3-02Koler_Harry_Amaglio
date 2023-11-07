<?php

namespace touiteur\message;
require_once "vendor/autoload.php";

use touiteur\exception as ex;

class touite
{
    //contenu du touite
    protected string $contenu;

    //auteur du touite
    protected string $auteur;

    //date de publication du touite
    protected string $date;

    //tableau contenant les tags du touite
    protected array $tag;

    /**
     * @param string $aut auteur
     * @param string $cont contenu du touite
     * @param string $date date
     * constructeur de touite
     */
    public function __construct(string $aut, string $cont, string $date)
    {
        //Le touite doit avoir un contenu inferrieur à 235 caractere
        if ($this->tailleTouite($cont) <= 235) {
            $this->auteur = $aut;
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