<?php
include '../../includes/connection/admincontrol.php';
include '../../includes/header.php';
?>

<body>
    <div class=" mx-auto flex justify-between w-[90%] px-10 py-6">
        <section class=" w-[40%] shadow-xl rounded-lg py-6 px-5">
            <table class=" text-sm overflow-x-auto table-auto">
                <thead>
                    <tr>
                        <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500">Bidang</th>
                        <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500">Deskripsi</th>
                        <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($queryBidang->rowCount() > 0) : ?>
                        <?php foreach ($listBidang as $index => $list) : ?>
                            <?= $index == 0 ? '' :
                                '<tr class="hover:bg-gray-100 px-2 py-2 text-md text-black">
                                <td class=" p-2">' . $list['bidang'] . '</td>
                                <td class=" p-2"> ' . $list['deskripsi'] . ' </td>
                                <td class=" py-3 text-slate-800">
                                    <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-red-800 transition-all duration-300"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>'; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Daftar Bidang Masih Kosong</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <section class=" w-[40%] shadow-xl rounded-lg py-6 px-5">
            <table class=" text-sm overflow-x-auto table-auto">
                <thead>
                    <tr>
                        <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500">Layanan</th>
                        <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500">Deskripsi</th>
                        <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($queryLayanan->rowCount() > 0) : ?>
                        <?php foreach ($listLayanan as $row) : ?>
                            <tr class="hover:bg-gray-100 p-3 text-md text-black" id="row-<?= $row['id_layanan']; ?>">
                                <td class=" p-2"><?= $row['layanan'] ?></td>
                                <td></td>
                                <td class=" py-3 text-slate-800">
                                    <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-red-800 transition-all duration-300"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td>Daftar Bidang Masih Kosong</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>