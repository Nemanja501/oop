<?php
class Product{
    private int $id;
    private string $name;
    private User $owner;
    private int $startingPrice;

    public function __construct()
    {
        
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function getId(){
        return $this->id;
    }

    public function setOwner(User $owner){
        $this->owner = $owner;
    }

    public function getOwner(){
        return $this->owner;
    }

    public function notifyOwnerAboutABid(User $user, int $amount){
        echo $this->owner->getName() . ", " . $user->getName() . " is interested in your product and is offering " . $amount . "\n";
    }

    public function notifyOwnerAboutABidWithdrawal(User $user){
        echo $this->owner->getName() . ", " . $user->getName() . " is no longer interested in your product \n";
    }
}

class User{
    private int $id;
    private string $name;

    public function __construct()
    {

    }

    public function getId(){
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setName(string $name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function notify(string $message){
        echo $this->name . ", " . $message . "\n";
    }
}

class AuctionMarketplace{
    private static $instance;
    private $wishlist;
    private $bidList;
    private $users;
    private $products;

    private function __construct()
    {
        $this->wishlist = [];
        $this->bidList = [];
        $this->users = [];
        $this->products = [];
    }

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new AuctionMarketplace();
        }
        return self::$instance;
    }

    public function addUser(User $user){
        $this->users[$user->getId()] = $user;
    }

    public function addProduct(Product $product){
        $this->products[$product->getId()] = $product;
    }

    public function addProductToWishlist(User $user, Product $product){
        $this->wishlist[] = new UserProductRelation($user->getId(), $product->getId());
    }

    public function removeProductFromWishlist(User $user, Product $product){
        foreach($this->wishlist as $key => $userProductRelation){
            if($userProductRelation->userId == $user->getId() && $userProductRelation->productId == $product->getId()){
                unset($this->wishlist[$key]);
                break;
            }
        }
    }

    public function makeBid(User $user, Product $product, int $amount){
        $this->addProductToWishlist($user, $product);
        $product->notifyOwnerAboutABid($user, $amount);
        $this->bidList[] = new UserProductRelation($user->getId(), $product->getId(), $amount);
    }

    public function withdrawBid(User $user, Product $product){
        $product->notifyOwnerAboutABidWithdrawal($user);
        foreach($this->bidList as $key => $userProductRelation){
            if($userProductRelation->userId == $user->getId() && $userProductRelation->productId == $product->getId()){
                unset($this->bidList[$key]);
                return;
            }
        }
    }

    public function sellProduct($userID, $productId){
        $user = $this->users[$userID];
        $product = $this->products[$productId];
        foreach($this->bidList as $userProductRelation){
            if($userProductRelation->userId == $userID && $userProductRelation == $productId){

            }
        }
    }

    public function notifyEveryoneInWishlist(string $message){
        foreach($this->wishlist as $userProductRelation){
            foreach($this->users as $user){
                if($userProductRelation->userId == $user->getId()){
                    $user->notify($message);
                }
            }
        }
    }
}

class UserProductRelation{
    public int $userId;
    public int $productId;
    public int $amount;

    public function __construct($userId, $productId, $amount = 0)
    {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->amount = $amount;
    }
}

$product = new Product();
$product->setId(14);
$product->setName('Painting');
$user = new User();
$user->setId(55);
$user->setName('Pera');
$user2 = new User();
$user2->setId(77);
$user2->setName('Nemanja');
$owner = new User();
$owner->setId(34);
$owner->setName('Marko');
$product->setOwner($owner);

AuctionMarketplace::getInstance()->addUser($user);
AuctionMarketplace::getInstance()->addUser($user2);
AuctionMarketplace::getInstance()->makeBid($user, $product, 100);
AuctionMarketplace::getInstance()->makeBid($user2, $product, 50);
AuctionMarketplace::getInstance()->sellProduct($user, $product);
