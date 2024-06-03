<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .bg {
            background-color: white;
            width: 65%;
            margin: 0 auto;
            position: relative;
            box-shadow: 0 15px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .d-flex-wrapper {
            display: flex;
        }

        .image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 20px;
        }

        .text-container {
            flex-grow: 1;
        }

        .bro {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 10px;
        }

        .bro img {
            margin-right: 10px;
        }

        .vm{
            color: black;
            opacity: 50%;
            font-size: 20px;
        }


        @media (max-width: 576px) {
            .bg {
                width: 90%;
            }

            .d-flex-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .image-container {
                margin-right: 0;
            }

            .bro {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="d-flex align-items-center justify-content-center" style="height: 100px; position: relative;">
        <button class="p-0" style="background: none; border: none; padding: 0; position: absolute; left: 0;">
            <img src="assets/img/back (5).png" alt="" class="mt-5 ms-5 d-block">
        </button>
        <p class="mt-5 mb-0 m-0">BookHaven</p>
    </div>

    <div class="bg mt-5 rounded-3">
        <div class="d-flex-wrapper">
            <div class="image-container">
                <img src="assets/img/JUANDARA.jpg" style="width: 140px; border-radius: 10px; height: 200px;" alt="" class="img1 mt-4">
                <button class="bro align-items-center justify-content-center border-0" style="width: 140px; height: 30px; border-radius: 5px; background-color: #cb0c9f;">
                    <img src="assets/img/open-book.png" alt="" style="width: 20px; height: 20px;">
                    <span>Read</span>
                </button>
                <button class="bro align-items-center justify-content-center border border-warning mt-2" style="width: 140px; height: 30px; border-radius: 5px;">
                    <img src="assets/img/open-book.png" alt="" style="width: 20px; height: 20px;">
                    <span>Rent</span>
                </button>
            </div>
            <div class="text-container">
                <p>Juan Dara</p>
                <p>By Cut Putri Khairan</p>
                <p>Romantic, Drama</p>
                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita numquam impedit itaque, quis quos vel! Quidem expedita, tempora voluptatibus fugiat alias, dolores totam, eligendi facilis repellendus sequi officia? Autem, a?. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, quasi autem dolore possimus excepturi dolores deserunt. Hic quasi fugit tempore iusto ex? Facere rem harum, dolor error rerum veniam quis? Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis nostrum amet ipsum dicta eum quibusdam fugit, voluptas non omnis autem nihil voluptates voluptate debit optio ducimus molestias, dolor iure numquam! lorem</span>
                <p class="vm mt-3">View More....</p>
            </div>
        </div>
    </div>

</body>
</html>
