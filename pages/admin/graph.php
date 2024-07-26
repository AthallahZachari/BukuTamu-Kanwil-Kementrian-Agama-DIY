<div class=" w-[50%] px-5 py-6 rounded-lg">
            <table class=" text-sm overflow-x-auto px-5 table-auto border">
                <thead>
                    <tr>
                        <th class="py-4 pr-2 pl-5 text-left font-medium border-b border-slate-400 text-slate-500">Layanan</th>
                        <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500">Deskripsi</th>
                        <th class="py-4 pl-2 pr-5 text-left font-medium border-b border-slate-400 text-slate-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($queryLayanan->rowCount() > 0) : ?>
                        <?php foreach ($listLayanan as $row) : ?>
                            <tr class="hover:bg-gray-100 p-3 text-md text-black" id="row-<?= $row['id_layanan']; ?>">
                                <td class=" pr-2 pl-5"><?= $row['layanan'] ?></td>
                                <td></td>
                                <td class=" py-3 pr-5 pl-2 text-slate-800  bg-violet-300 ">
                                    <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-slate-200 transition-all duration-300"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button onclick="" class=" px-2 py-1 border border-slate-400 rounded-md hover:bg-red-500 transition-all duration-300"><i class="fa-solid fa-trash"></i></button>
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
        </div>