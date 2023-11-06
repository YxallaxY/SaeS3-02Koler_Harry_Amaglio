<?php
require_once "exception/InvalidePropety";

class touite
{
    //contenu du touite
    protected string $contenu;

    //auteur du touite
    protected string $auteur;

    //date de publication du touite
    protected string $date;

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
     * Methode magique get permetant de recupere les parametre proteger
     * @param string $at nom du parametre a recuperer
     * @return mixed type du parametre renvoye
     * @throws InvalidePropety class d'exception sur les propiete invalide
     */
    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        } else {
            throw new InvalidePropety("$at: invalide propety ");
        }
    }

}