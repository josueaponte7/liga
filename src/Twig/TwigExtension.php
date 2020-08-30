<?php
// src/Twig/TwigExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Equipo;
use App\Entity\Posicion;


class TwigExtension extends AbstractExtension
{
    private $em = null;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('equipo', [$this, 'getEquipo']),
            new TwigFunction('posicion', [$this, 'getPosicion']),
        ];
    }

    public function formatPrice($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price.' €';

        return $price;
    }

    public function getEquipo($equipoId)
    {
        $repositorio = $this->em->getRepository(Equipo::class);
        $equipo = $repositorio->find($equipoId);
        return  $equipo->getNombre();
    }
    
    public function getPosicion($posicionId)
    {
        $repositorio = $this->em->getRepository(Posicion::class);
        $posicion = $repositorio->find($posicionId);
        return  $posicion->getNombre();
    }
    
}