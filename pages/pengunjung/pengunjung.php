<?php include '../../includes/header.php' ?>

<body class="min-h-screen w-full flex flex-col items-center justify-center relative bg-fixed bg-center bg-repeat" style="background-image: url('../../assets/belakang.avif');">
    
    <div class="w-[50%] px-10 py-6 my-6 rounded-sm shadow-xl bg-white">
        <section class="items-center border-b-[1.5px] border-gray-400 pb-4">
            <section class="">
                <h1 class="text-3xl text-slate-700 font-bold">
                    <i class="fa-regular fa-address-book mr-2 p-4 rounded-[50%] text-green-700 border border-slate-700"></i>
                    Form Pengunjung
                </h1>
            </section>
        </section>
        <?php include './form_pengunjung.php' ?>
    </div>
</body>
<div class="w-full">
    <?php include '../../includes/footer.php' ?>
</div>