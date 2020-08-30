<?php
// src/Twig/TwigExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use App\Entity\Clientes;
use App\Entity\Equipo;


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
        ];
    }

    public function formatPrice($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = $price.'€';

        return $price;
    }

    public function getEquipo($equipoId)
    {
        $repositorio = $this->em->getRepository(Equipo::class);
        $equipo = $repositorio->find($equipoId);
        return  $equipo->getNombre();
    }
}