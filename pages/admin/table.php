<?php
include '../../includes/connection/admincontrol.php';
include '../../includes/header.php';


?>

<!-- Tampilkan form pencarian -->
<div class="min-h-[60vh] mx-auto pb-6">
    <section class="shadow-lg rounded-md my-4 py-3 px-5 w-full flex justify-between ">
        <form method="GET" action="dashboard.php" class="w-[80%] flex items-center ">
            <select name="filter" id="filter" class=" appearance-none rounded-tl-lg rounded-bl-md px-4 py-[4.0px] border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                <option value="" disabled <?= $filter === 'all' ? 'selected' : '' ?>>Filter</option>
                <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>Semua</option>
                <option value="today" <?= $filter === 'today' ? 'selected' : '' ?>>Hari Ini</option>
                <option value="month" <?= $filter === 'month' ? 'selected' : '' ?>>Bulan Ini</option>
                <option value="year" <?= $filter === 'year' ? 'selected' : '' ?>>Tahun Ini</option>
                <!-- Add your filter options here -->
            </select>
            <input type="text" name="searchbox" value="<?= htmlspecialchars($searchbox) ?>" placeholder="Cari nama..." class="w-[30%] px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-slate-100 font-semibold px-4 py-[4.7px] rounded-tr-md rounded-br-md transition-all duration-300">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
        <nav class=" text-slate-100 ">
            <ul class=" bg-green-700 rounded-md flex justify-center items-center align-middle">
                <li class="px-5 py-2 hover:bg-green-900 cursor-pointer rounded-tl-md rounded-bl-md transition-all duration-300">Keagamaan</li>
                <li class="px-5 py-2 hover:bg-green-900 cursor-pointer transition-all duration-300">Umum</li>
                <li class="px-5 py-2 hover:bg-green-900 cursor-pointer rounded-tr-md rounded-br-md transition-all duration-300">Administratif</li>
            </ul>
        </nav>
    </section>


    <!-- Tampilkan tabel dengan hasil pencarian -->
    <div class="shadow-xl rounded-lg py-6 px-5 ">
        <table class="text-sm overflow-x-auto table-auto">
            <!-- Tabel header -->
            <thead>
                <tr>
                    <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500 w-[2%] "></th>
                    <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500 w-[12.5%]">
                        </">Nama</th>
                    <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500 w-[5%] ">
                        </">Gender</th>
                    <th class="py-4 px-2 text-center font-medium border-b border-slate-400 text-slate-500 w-[5%]">
                        </">Instansi</th>
                    <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500 w-[12.5%]">
                        </">Alamat</th>
                    <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500 w-[5%] ">
                        </">Nomor HP</th>
                    <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500 w-[13%] ">
                        </">Bidang</th>
                    <th class="py-4 px-2 text-left font-medium border-b border-slate-400 text-slate-500 w-[15%]">
                        </">Keperluan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($stmt->rowCount() > 0) : ?>
                    <?php foreach ($rows as $row) : ?>
                        <tr class="hover:bg-gray-100 px-2 py-2 align-text-top text-md text-black">
                            <td class="text-center align-text-top">
                                <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-200 transition-all duration-300"><i class="fa-solid fa-ellipsis"></i></a>
                            </td>
                            <td><?= htmlspecialchars($row["nama"]); ?></td>
                            <td><?= htmlspecialchars($row["jenis_kelamin"]); ?></td>
                            <td><?= htmlspecialchars($row["instansi"]); ?></td>
                            <td><?= htmlspecialchars($row["alamat"]); ?></td>
                            <td><?= htmlspecialchars($row["nomor_hp"]); ?></td>
                            <td class=" py-2">
                                <?php
                                $instansi = htmlspecialchars($row['kepentingan']);
                                $setBgColor = getBgColor($instansi);
                                ?>
                                <p class=" bg-<?= $setBgColor ?> p-2 rounded-md"><?= $instansi ?></p>
                            </td>
                            <td class=" px-2 py-2 text-md align-text-top text-left text-black"><?= htmlspecialchars($row["keperluan"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="py-2 px-4 text-center text-gray-700">No results found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <section class="min-h-16 mt-3 flex justify-between items-center">
            <p class="text-slate-400 text-sm font-semibold">Showing page <?= $page; ?> of <?= $total_pages; ?> pages</p>
            <div>
                <a href="dashboard.php?page=<?= max(1, $page - 1); ?>" class="hover:bg-slate-200 text-green-800 font-semibold border border-slate-400 px-4 py-2 mr-3 rounded-md transition-all duration-300">
                    <i class="fa-solid fa-chevron-left mr-3"></i>Prev
                </a>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a href="dashboard.php?page=<?= $i; ?>" class="px-3 py-2 font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300"><?= $i; ?></a>
                <?php endfor; ?>
                <a href="dashboard.php?page=<?= ($page + 1 <= $total_pages) ? $page + 1 : $total_pages; ?>" class="bg-green-700 hover:bg-green-800 text-slate-100 font-semibold border border-slate-400 px-4 py-2 ml-3 rounded-md transition-all duration-300">
                    Next<i class="fa-solid fa-chevron-right ml-3"></i>
                </a>
            </div>
        </section>
    </div>
</div>