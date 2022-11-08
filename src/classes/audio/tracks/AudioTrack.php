<?php
namespace iutnc\deefy\audio\tracks;
use Exception;

abstract class AudioTrack
{
    protected string $titre;
    protected string $genre;
    protected int $duree = 0;
    protected string $nomFich;

    public function __construct(string $titre, string $cheminFich)
    {
        $this->titre = $titre;
        $this->nomFich = $cheminFich;
    }

    public function __toString() : string
    {
        return json_encode($this);
    }

    public function __get(string $attrname) : mixed
    {
        if (property_exists($this, $attrname)) return $this->$attrname;
        throw new Exception(get_called_class(). ": invalid property : $attrname");
    }

    public function __set(string $attrname, mixed $value) : void
    {
        if (! property_exists($this, $attrname))
        throw new Exception("invalid property : $attrname");

        if ($attrname === 'titre' || $attrname === 'nomFich')
        {
            throw new NonEditablePropertyException(get_called_class(). ": propriete non modifiable : $value");
        }

        elseif ($attrname === 'duree' && $value < 0) {
            throw new InvalidPropertyValueException(get_called_class(). ": mauvaise valeur de propriete pour attribut duree : $value");
        }

        $this->$attrname = $value;
        return;
    }

}

?>
