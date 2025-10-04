<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body  class="antialiased md:min-h-screen md:flex md:flex-col">
    
        <!-- Header Section -->
         @include('user.header')

    
        <!-- Body Section -->
         @include('user.hero')

         <!-- Products Section -->
           <section id="shop" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
                @include('user.shop.index', ['products' => $products])
            </section>
                
@include('user.contact')

         <!--Footer Section -->
         @include('user.footer')
    
    
</body>
</html>