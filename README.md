<h1 align="center" id="title">Shop Portal (Laravel E-commerce project)</h1>

<p align="center"><img src="readme-image.svg" alt="Shop-Portal" width="640" height="320" /></p>

## Description

### Shop Portal is a modern E-commerce web app made using TALL Stack(Tailwind CSS, Alpine JS, Laravel, Livewire). It's designed to make online shopping easy for customers and give store owners the tools they need to manage their business smoothly.

## Demo

View live demo here: https://shop-portal.free.nf

## Features

Here're some of the project's best features:

-   ### Promotional Carousel
    Dynamic slides showcasing ongoing promotions.
-   ### Featured Products Section
    Highlighting best products for easy access.
-   ### Special Discount Feature
    Discounts on products from specific categories.
-   ### Wishlist
    Save your favorite items for later.
-   ### Shopping Cart
    -   <strong>Easy Management:</strong> Quickly add, remove, or change the quantity of products in the cart.
    -   <strong>Clear Pricing:</strong> Show total prices, discounts, and subtotals clearly, helping customers feel good about their purchases.
    -   <strong>Smooth Checkout:</strong> Redirect users to a secure checkout, and automatically clear the cart after an order is placed for a hassle-free experience.
-   ### Checkout Options
    Enjoy easy offline cash on delivery option or online payment processing with Razorpay integration, ensuring secure transactions every time.
-   ### Contact Form
    Make it simple for customers to reach out with a built-in contact form, improving communication and support.
-   ### Product Management
    Take control with features like categories / sub-categories, product filters, and customer reviews, creating a rich shopping experience.
-   ### Admin Panel
    Manage the store with ease through a secure admin interface, allowing for quick updates and oversight of operations.
-   ### User Authentication
    Provide secure login and registration with Jetstream, giving users peace of mind while they shop.
-   ### Responsive UI
    A beautiful and responsive design using Tailwind CSS and DaisyUI.

## 🛠️ Installation Steps:

<p>1. Install Composer</p>

```
https://getcomposer.org/
```

<p>2. Clone the project</p>

```
https://github.com/Riju-88/Shop-Portal.git
```

<p>3. Install the Laravel packages and dependencies</p>

```
composer install
```

<p>4. Install Node JS and Node packages</p>

```
npm install
```

<p>5. Create the .env file by running the following command:</p>

```
cp .env.example .env
```

<p>6. Re-configure the mail information in the .env for using email features. It'll be set to these values by default:</p>

```
MAIL_MAILER=smtp MAIL_HOST=mailpit MAIL_PORT=1025 MAIL_USERNAME=null MAIL_PASSWORD=null MAIL_ENCRYPTION=null MAIL_FROM_ADDRESS="hello@example.com" MAIL_FROM_NAME="${APP_NAME}"
```

<p>7. Add Razorpay payment gateway API Key and Secret for using payment feature</p>

```
RAZORPAY_API_KEY= "*********"  RAZORPAY_API_SECRET= "***********"
```

<p>8. Add Google Client ID Secret and redirect URI to use google login feature</p>

```
GOOGLE_CLIENT_ID=  GOOGLE_CLIENT_SECRET=  GOOGLE_REDIRECT_URI=
```

<p>9. Generate a new application key by running this command:</p>

```
php artisan key:generate
```

<p>10. Run the migrations to generate tables:</p>

```
php artisan migrate
```

<p>11. Start the node server:</p>

```
npm run dev
```

<p>12. Start the app:</p>

```
php artisan serve
```

## Database Seed

<p>Run the seed command to populate database with placeholder data.</p>
<p>Currently available seeders: UserSeeder, ShippingMethodsSeeder, ProductSeeder, PaymentMethodSeeder. </p>
<p>Modify the structure of the placeholder data in their corresponding Factory file. </p>

```
php artisan db:seed --class=Seeder_File_Name
```

<h2>💻 Built with</h2>

Technologies used in the project:

-   [Laravel](https://laravel.com/)
-   [Livewire](https://livewire.laravel.com/)
-   [Alpine JS](https://alpinejs.dev/)
-   [Tailwind CSS](https://tailwindcss.com/)
-   [Filament PHP](https://filamentphp.com/)
-   [DaisyUI](https://daisyui.com/)

<h2>🌟 Like my work?</h2>

Feel free to reach out if you’d like to hire me or need support regarding this project. Contact me at rijumistri4@gmail.com
