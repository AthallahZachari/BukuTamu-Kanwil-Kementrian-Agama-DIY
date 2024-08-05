<?php
include '../../includes/connection/admincontrol.php';
include '../../includes/header.php';

?>

<!-- Tampilkan form pencarian -->
<div class="min-h-[60vh] mx-auto ">
    <!-- Tampilkan tabel dengan hasil pencarian -->
    <div class="shadow-xl rounded-lg py-6 px-5 my-5">

        <!-- [ TOOLBAR ] -->
        <section class="my-4 w-full flex justify-between items-center">
            <!-- [ FILTER &  SEARCH ] Filter Harian, Bulanan, Tahunan. Search by name -->
            <form method="GET" action="" class="w-[65%] flex items-center ">
                <select name="filter" id="filter" class="appearance-none rounded-tl-lg rounded-bl-md px-4 py-[4.0px] border border-gray-300 hover:cursor-pointer hover:bg-slate-100 transition-all duration-200 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                    <option value="" disabled <?= $filter === 'all' ? 'selected' : '' ?>>Filter</option>
                    <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>Semua</option>
                    <option value="today" <?= $filter === 'today' ? 'selected' : '' ?>>Hari Ini</option>
                    <option value="month" <?= $filter === 'month' ? 'selected' : '' ?>>Bulan Ini</option>
                    <option value="year" <?= $filter === 'year' ? 'selected' : '' ?>>Tahun Ini</option>
                </select>
                <input type="text" name="searchbox" value="<?= htmlspecialchars($searchbox) ?>" placeholder="Cari nama..." class="w-[30%] px-4 py-1 border border-gray-300 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-slate-100 font-semibold px-4 py-[4.7px] rounded-tr-md rounded-br-md transition-all duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <div class=" w-[35%] flex justify-end items-center">
                <!-- [ FILTER ] Tanggal -->
                <form method="GET" action="" id="dateFilterForm">
                    <input type="date" name="filterDate" id="filterDateInput" class="mr-2 px-3 py-1 rounded-md border border-gray-300 hover:cursor-pointer">
                </form>

                <!-- [ FILTER ] Layanan -->
                <form id="filterBidang" method="POST" action="">
                    <nav class="text-sm text-slate-900">
                        <a id="dropdownButton" class="dropdownButton w-full px-3 py-2 rounded-md border border-gray-300 hover:bg-slate-100 transition-all duration-300 hover:cursor-pointer focus:outline-none focus:ring-1 focus:ring-emerald-400">
                            Filter Layanan<i class="fa-solid fa-chevron-down ml-2"></i>
                        </a>
                        <div id="dropdownMenu" class="hidden absolute mt-3 z-10 bg-white border border-gray-300 rounded-md shadow-lg">
                            <ul>
                                <?php foreach ($listLayanan as $list) { ?>
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" data-value="<?= $list['id_layanan']; ?>"><?= $list['layanan']; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <input type="hidden" name="filterLayanan" id="kepentinganID" />
                    </nav>
                </form>

                <!-- [ EXPORT ] Export to Excel -->
                <a href="export_excel.php" class="text-green-700 text-sm ml-2 px-3 py-2 border border-gray-300 hover:bg-slate-100 rounded-md transition-all duration-300">
                    <i class="fa-solid fa-file-export"></i>
                </a>
            </div>
        </section>

        <!-- [ TABLE ] -->
        <table class="text-sm overflow-x-auto table-auto w-full">
            <thead>
                <tr>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-[5%]">Tanggal</th>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-[12.5%]">Nama</th>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-[5%]">Gender</th>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-auto">Umur</th>
                    <th class="py-4 px-2 text-center font-medium border-y border-slate-400 text-slate-500 w-auto">Instansi</th>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-auto">Alamat</th>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-auto">Nomor HP</th>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-auto">Layanan</th>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-auto">Bidang</th>
                    <th class="py-4 px-2 text-left font-medium border-y border-slate-400 text-slate-500 w-auto">Deskripsi</th>
                    <th class="py-4 px-2 font-medium border-y border-slate-400 text-slate-500 w-[160px]">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($query->rowCount() > 0) : ?>
                    <?php foreach ($rows as $row) : ?>
                        <?php
                        $bgClass = ($row['progres'] == 'unassigned' ? 'bg-red-500 mt-3' : '');
                        $date = DateTime::createFromFormat('Y-m-d', $row["tanggal"]);
                        $formattedDate = $date->format('d-m-Y');
                        ?>
                        <tr class="hover:bg-gray-100 px-2 py-2 text-md text-black odd:bg-slate-100" id="row-<?= $row['id_pengunjung']; ?>">
                            <input type="hidden" name="id_pengunjung" value="<?= htmlspecialchars($row["id_pengunjung"]); ?>">
                            <td class="px-2 align-text-top rounded-s-lg"><?= htmlspecialchars($formattedDate); ?></td>
                            <td class="px-2 align-text-top"><?= htmlspecialchars($row["nama"]); ?></td>
                            <td class="px-2 align-text-top"><?= htmlspecialchars($row["jenis_kelamin"]); ?></td>
                            <td class="text-center align-text-top"><?= htmlspecialchars($row["umur"]); ?></td>
                            <td class="px-1 align-text-top text-center"><?= htmlspecialchars($row["instansi"]); ?></td>
                            <td class="align-text-top"><?= htmlspecialchars($row["alamat"]); ?></td>
                            <td class="p-2 align-text-top"><?= htmlspecialchars($row["nomor_hp"]); ?></td>
                            <td class="p-2 align-text-top"><?= htmlspecialchars($row["layanan"]); ?></td>
                            <td id="bidang-cell-<?= htmlspecialchars($row["id_pengunjung"]); ?>" class="align-text-top">
                                <div class="p-2 rounded-md <?= $bgClass ?>"><?= htmlspecialchars($row["bidang"]); ?></div>
                            </td>
                            <td class="px-2 py-2 text-md align-text-top text-left text-black"><?= htmlspecialchars($row["deskripsi"]); ?></td>
                            <td class="py-5 text-sm text-center align-text-top rounded-e-lg w-auto">
                                <form action="../../includes/connection/admincontrol.php" method="post">
                                    <a id="btnDropdownBidang-<?= $row['id_pengunjung']; ?>" class="btnDropdownBidang px-3 py-2 rounded-md text-slate-200 bg-green-700 hover:bg-green-800 transition-all duration-300 hover:cursor-pointer focus:outline-none focus:ring-1 focus:ring-emerald-">
                                        Tambah Bidang <i class="fa-solid fa-chevron-down ml-2"></i>
                                    </a>
                                    <div id="listDropdownBidang-<?= $row['id_pengunjung']; ?>" class="listDropdownBidang hidden absolute mt-3 z-9 bg-white border border-gray-300 rounded-md shadow-lg">
                                        <ul class="text-left">
                                            <?php foreach (array_slice($listBidang, 1) as $data) { ?>
                                                <li class="px-4 py-2 cursor-pointer hover:bg-gray-100" data-value="<?= htmlspecialchars($data['id_bidang']); ?>">
                                                    <?= htmlspecialchars($data['bidang']); ?>
                                                </li>
                                            <?php } ?>

                                        </ul>
                                    </div>
                                    <input type="hidden" name="selectedOption" class="bidangID">
                                    <input type="hidden" name="id_pengunjung" value="<?= $row['id_pengunjung'] ?>" />
                                    <input type="hidden" name="current_page" value="<?= $page ?>" />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="py-2 px-4 text-center text-gray-700">No results found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <section class="min-h-16 mt-3 flex justify-between items-center border-t border-slate-400">
            <p class="text-slate-600 text-sm ">Showing <?= $start_row; ?> - <?= $end_row ?> row of total <?= $total_rows; ?> rows</p>
            <p class="text-slate-600 text-sm ">Page <?= $page; ?> of <?= $total_pages; ?> pages</p>
            <div>
                <a href="dashboard.php?page=<?= max(1, $page - 1); ?>" class="hover:bg-slate-200 text-green-800 font-semibold border border-slate-400 px-4 py-2 mr-3 rounded-md transition-all duration-300">
                    <i class="fa-solid fa-chevron-left mr-3"></i>Prev
                </a>
                <?php if ($page > 3) : ?>
                    <a href="dashboard.php?page=1" class="px-3 py-2 font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300">1</a>
                    <?php if ($page > 4) : ?>
                        <span class="px-3 py-2 font-semibold">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) : ?>
                    <a href="dashboard.php?page=<?= $i; ?>" class="px-3 py-2 font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300 <?= $i == $page ? 'bg-green-700 text-slate-100' : '' ?>"><?= $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages - 2) : ?>
                    <?php if ($page < $total_pages - 3) : ?>
                        <span class="px-3 py-2 font-semibold">...</span>
                    <?php endif; ?>
                    <a href="dashboard.php?page=<?= $total_pages; ?>" class="px-3 py-2 font-semibold rounded-md border border-slate-400 hover:bg-gray-200 transition-all duration-300"><?= $total_pages; ?></a>
                <?php endif; ?>

                <a href="dashboard.php?page=<?= min($total_pages, $page + 1); ?>" class="bg-green-700 hover:bg-green-800 text-slate-100 font-semibold border border-slate-400 px-4 py-2 ml-3 rounded-md transition-all duration-300">
                    Next<i class="fa-solid fa-chevron-right ml-3"></i>
                </a>
            </div>
        </section>


    </div>
</div>

<script>
    document.getElementById('filterDateInput').addEventListener('change', function() {
        document.getElementById('dateFilterForm').submit();
    });

    
    // [ TOGGLE ] tombol dropdown
    // 
    function toggleVisibility(element) {
        if (element) {
            element.classList.toggle("hidden");
        } else {
            console.error("Element not found.");
        }
    }


    // [ HANDLER ] to handle dropdown selection
    // 
    function handleDropdownSelection(e) {
        const selectedValue = e.target.getAttribute("data-value");
        const dropdownButton = document.getElementById("dropdownButton");
        const hiddenInput = document.getElementById("kepentinganID");
        const dropdownMenu = document.getElementById("dropdownMenu");
        const form = document.getElementById("filterBidang");

        if (selectedValue && hiddenInput && dropdownButton && dropdownMenu && form) {
            hiddenInput.value = selectedValue;
            dropdownButton.textContent = e.target.textContent;
            dropdownMenu.classList.add("hidden");
            form.submit();
        } else {
            console.error("One or more elements not found.");
        }
    }


    // [ TOGGLE ] Filter Layanan
    // 
    document.getElementById("dropdownButton").addEventListener("click", function() {
        const dropdownMenu = document.getElementById("dropdownMenu");
        toggleVisibility(dropdownMenu);
    });


    // [ HANDLER ] Pilihan layanan
    // 
    document.querySelectorAll("#dropdownMenu li").forEach(function(item) {
        item.addEventListener("click", handleDropdownSelection);
    });


    // [ HANDLE ] Menu Bidang
    // 
    document.querySelectorAll(".btnDropdownBidang").forEach(function(button) {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            const id = e.target.id.split('-')[1];
            const listDropdown = document.getElementById(`listDropdownBidang-${id}`);
            toggleVisibility(listDropdown);
        });
    });


    // [ HANDLE ] Pilihan Bidang
    // 
    document.querySelectorAll(".listDropdownBidang li").forEach(function(item) {
        item.addEventListener("click", function(e) {
            const selectedValue = e.target.getAttribute("data-value");
            const parentForm = e.target.closest("form");
            const hiddenInput = parentForm.querySelector(".bidangID");

            if (selectedValue && hiddenInput) {
                hiddenInput.value = selectedValue;
                parentForm.submit();
            } else {
                console.error("Selected value or hidden input not found.");
            }
        });
    });
</script>