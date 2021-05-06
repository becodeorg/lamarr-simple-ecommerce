<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\Shoppingcart;
use App\Entity\ShoppingLine;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingCartController extends AbstractController
{
    #[Route('/shopping/cart/addproduct', name: 'shopping_cart_add', methods: ['post'])]
    public function addProduct(): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($_POST['id']);

        if(!$product instanceof Product) {
            $this->addFlash('error', 'Could not find product');
        }

        if($this->getUser() === null) {
            $this->redirectToRoute('app_login');
        }

        /** @var Customer $user */
        $user = $this->getUser();

        $shoppingCart = $user->getSingleCart();
        $shoppingCart->addShoppingLine(new ShoppingLine($product, $_POST['quantity']));

        $this->getDoctrine()->getManager()->persist($shoppingCart);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('shopping_cart');
    }

    #[Route('/shopping/cart', name: 'shopping_cart')]
    public function index(): Response {
        if($this->getUser() === null) {
            $this->redirectToRoute('app_login');
        }

        /** @var Customer $user */
        $user = $this->getUser();

        $shoppingCart = $user->getSingleCart();

        return $this->render('shopping_cart/index.html.twig', [
            'cart' => $shoppingCart,
        ]);
    }

}
