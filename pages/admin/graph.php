<?php
include '../../includes/connection/connection.php';
include '../../includes/connection/admincontrol.php';
include '../../includes/connection/graphcontrol.php';
include '../../includes/header.php';

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* Hide scrollbar for all browsers */
    .scroll-container {
        overflow-x: scroll;
        /* Enable scrolling */
        -ms-overflow-style: none;
        /* Hide scrollbar in Internet Explorer and Edge */
        scrollbar-width: none;
        /* Hide scrollbar in Firefox */
    }

    /* Hide scrollbar for Webkit browsers */
    .scroll-container::-webkit-scrollbar {
        display: none;
        /* Hide the scrollbar */
    }
</style>

<body class="min-h-[100vh] px-10">
    <section>
        <form method="GET" action="" class="hidden px-5 py-3 my-5 text-slate-600 rounded-md shadow-lg w-[350px]">
            <select id="month" name="month" class="pl-3 py-2 border border-slate-400 rounded-md hover:cursor-pointer hover:bg-slate-200 transition-all duration-300">
                <option value="this_month" class="" <?php if (isset($_GET['month']) && $_GET['month'] == 'this_month') echo 'selected'; ?>>Bulan Ini</option>
                <option value="last_month" <?php if (isset($_GET['month']) && $_GET['month'] == 'last_month') echo 'selected'; ?>>Bulan Kemarin</option>
            </select>
            <button type="submit" class="ml-3 px-5 py-2 rounded-md text-slate-200 font-semibold bg-green-700 hover:bg-green-800 transition-all duration-300">Tampilkan</button>
        </form>
        <div class="scroll-container py-3">
            <div class="flex space-x-6 ">

                <!-- PENGUNJUNG HARIAN -->
                <div class="w-[450px] h-auto p-5 rounded-md shadow-lg flex-shrink-0">
                    <section class=" flex justify-between mb-5">
                        <h3 class="text-lg text-slate-700 font-bold">Grafik Harian</h3>
                        <a id="btnDetailPengunjung" class=" text-slate-400 text-sm font-semibold hover:cursor-pointer">Lihat Detail<i class="fa-solid fa-chevron-down ml-2"></i></a>
                    </section>
                    <canvas id="dailyChart"></canvas>
                    <div id="detailPengunjung" class="grid grid-cols-2 mt-3 hidden">
                        <div class="flex items-center px-2 py-3 text-xs">
                            <i class="fa-solid fa-user mr-3 "></i>
                            <div class="flex flex-col ">
                                <p class=" text-slate-400 font-semibold">PENGUNJUNG HARI INI</p>
                                <p class=" text-slate-800 font-bold "><?= $dailyCount ?> Orang</p>
                            </div>
                        </div>
                        <div class="flex items-center px-2 py-3 text-xs">
                            <i class="fa-solid fa-user-group mr-3 "></i>
                            <div class="flex flex-col">
                                <p class=" text-slate-400 font-semibold">TOTAL PENGUNJUNG</p>
                                <p class=" text-slate-800 font-bold "><?= $totalVisitors ?> Orang</p>
                            </div>
                        </div>
                        <div class="flex items-center px-2 py-3 text-xs">
                            <i class="fa-solid fa-user-group mr-3 "></i>
                            <div class="flex flex-col">
                                <p class=" text-slate-400 font-semibold">AVG</p>
                                <p class=" text-slate-800 font-bold "><?= $averageDailyVisitors ?> Orang</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PENGUNJUNG MINGGUAN -->
                <div class="w-[450px] h-[300px] p-5 rounded-md shadow-lg flex-shrink-0 ">
                    <h3 class="text-lg text-slate-700 font-bold">Grafik Mingguan</h3>
                    <canvas id="weeklyChart"></canvas>
                </div>

                <div class="w-[450px] h-[300px] p-5 rounded-md shadow-lg flex-shrink-0 ">
                    <h3 class="text-lg text-slate-700 font-bold">Grafik Bulanan</h3>
                    <canvas id="monthlyChart"></canvas>
                </div>

                <div class="w-[450px] h-[300px] p-5 rounded-md shadow-lg flex-shrink-0 hidden">
                    <h3 class="text-lg text-slate-700 font-bold">Grafik Tahunan</h3>
                    <canvas id="yearlyChart"></canvas>
                </div>

                <div class="w-[450px] h-[300px] p-5 rounded-md shadow-lg flex-shrink-0">
                    <h3 class="text-lg text-slate-700 font-bold">Pengunjung</h3>
                    <div class=" w-[200px] mx-auto">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // TOGGLE FUNCTION
        function toggleVisibility(element) {
            element.classList.toggle("hidden");
        }

        // Attach event listener to the dropdown filter button
        document.getElementById("btnDetailPengunjung").addEventListener("click", function() {
            const dropdownMenu = document.getElementById("detailPengunjung");
            toggleVisibility(dropdownMenu);
        });

        // [ GET ] Data from PHP
        const dataDailyFromPHP = <?php echo json_encode($dataDaily); ?>;
        const dataWeeklyFromPHP = <?php echo json_encode($dataWeekly); ?>;
        const dataMonthlyFromPHP = <?php echo json_encode($dataMonthly); ?>;
        const dataYearlyFromPHP = <?php echo json_encode($dataYearly); ?>;
        const dataGenderFromPHP = <?php echo json_encode($dataGender); ?>;

        // [ GET ] Fetch data pengunjung harian
        const dailyLabels = dataDailyFromPHP.map(item => item.day_name);
        const dailyData = dataDailyFromPHP.map(item => item.visitors_count);

        // [ GET ] Fetch data pengunjung mingguan
        const weeklyLabels = dataWeeklyFromPHP.map(item => 'Week ' + item.week_number);
        const weeklyData = dataWeeklyFromPHP.map(item => item.visitors_count);

        // [ GET ] Fetch data pengunjung bulanan
        const monthlyLabels = dataMonthlyFromPHP.map(item => item.month_name);
        const monthlyData = dataMonthlyFromPHP.map(item => item.visitors_count);

        // // [ GET ] Fetch data pengunjung tahunan
        const yearlyLabels = dataYearlyFromPHP.map(item => item.year);
        const yearlyData = dataYearlyFromPHP.map(item => item.visitors_count);

        // // [ GET ] Fetch data jenis kelamin
        const genderLabels = dataGenderFromPHP.map(item => item.gender === 'pria' ? 'Pria' : 'Wanita');
        const genderData = dataGenderFromPHP.map(item => item.visitors_count);

        // Get the canvas context for daily chart
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');

        // Create the daily chart
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Jumlah Pengunjung Harian',
                    data: dailyData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Get the canvas context for weekly chart
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');

        // Create the weekly chart
        new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Jumlah Pengunjung Mingguan',
                    data: weeklyData,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Get the canvas context for monthly chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

        // Create the monthly chart
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Jumlah Pengunjung Bulanan',
                    data: monthlyData,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Get the canvas context for yearly chart
        const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');

        // Create the yearly chart
        new Chart(yearlyCtx, {
            type: 'line',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Jumlah Pengunjung Tahunan',
                    data: yearlyData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Get the canvas context for gender chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');

        // Create the gender chart
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: genderLabels,
                datasets: [{
                    label: 'Distribusi Pengunjung Berdasarkan Jenis Kelamin',
                    data: genderData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.label}: ${tooltipItem.raw} pengunjung`;
                            }
                        }
                    }
                },
                elements: {
                    arc: {
                        borderWidth: 1, // Adjust the border width if needed
                        borderColor: '#fff' // Set border color to white or any color you prefer
                    }
                }
            }
        });
    </script>
</body>