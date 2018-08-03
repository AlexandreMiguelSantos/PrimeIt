The Discount Api is composed by 3 main classes and have the follow directory structure:

Api\
    \Controller
    \Entity
    \Json\
        \Customer
        \Order
        \Products

The Json Directory have the files retrieved form the site an are only used for testing propose.

The controller is the request.php and can be added more functions by adding new method's,
for the moment only Order is created, in case of more types of request Should be add on the class.

The Order class is the the responsible for the treatment of the data.
It set the communication with the rest os the system and must be changed to the correct settings.
The order also set the discount class.
In the Total value of the request is calculated in this class having all the discounts.

The discount class can be updated by adding more method's.
For each new type of discount should be created the new logic.
This class can be upgraded to a db table and set some values for same kind of discount.
Ex: discount for different Customer revenues having different discount values.

The Class discount can also be access by different processes, in case the structure allow it.
ex: when the costumer is instantiated set the discount variable for it.

Some errors are treated and stop the rest of the precess.
Did't created a some checks as authentication,
I think is not the main request never the less should be check before the request is set.

Treated errors:
Empty request.
No Order Id.
No Customer Id.
No items

Specs of this Api to test:
The request is made by a GET to be easily tested.
The link.
'ServerYouUse_our_IP'/Api/index.php?order=1
By changing be 'order=1' it will ge the other json order's
To add other orders to test as json files save the json file as "order'number_that_you_ want'.json".
Ex: order=1 load the Order1.json file.

Api specks to communication
'id'            -> Order Id
'customer-id'   -> customer Id (must after be made the match with the correct property).
'items'         -> Set of products
{
       'product-id' ->Product Id (must after be made the match with the correct property).
       'quantity'   -> Quantity of purchased product(quantity + discount offer).
       'unit-price' -> price of a unit of product(must after be made the match with the correct property).
       'total'      -> Total price for the product (unit-price * quantity * Discount for the product
}
'total'         -> Total value of the order ((Sum('item'->'total') * Discount)
