import Swal from "sweetalert2";
import Chart from "chart.js/auto";
import axios from "axios";
import "./bootstrap";
import "./main";

window.Swal = Swal;

const chart = async () => {
    const tahun = document.getElementById("tahun");
    const chartId = document.getElementById("charts");
    let myChart; // Variabel untuk menyimpan objek grafik

    const monthNames = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    // Fungsi untuk menggambar grafik berdasarkan tahun yang dipilih
    async function drawChart(selectedYear) {
        if (myChart) {
            // Hapus objek grafik sebelumnya jika ada
            myChart.destroy();
        }

        const user = await axios.get(
            `http://127.0.0.1:8000/api/get-apply?filter_year=${selectedYear}`
        );
        const months = user.data.data[0].months;

        myChart = new Chart(chartId, {
            type: "bar",
            data: {
                labels: months.map((row) => monthNames[row.month - 1]),
                datasets: [
                    {
                        label: "Data User Perbulan",
                        data: months.map((row) => row.count),
                    },
                ],
            },
        });
    }

    // Fungsi untuk menangani perubahan tahun
    function changeYear(e) {
        const selectedYear = e.target.value;
        console.log(selectedYear);
        // Panggil fungsi untuk menggambar grafik dengan tahun yang dipilih
        drawChart(selectedYear);
    }

    // Tambahkan event listener untuk perubahan tahun
    tahun.addEventListener("change", changeYear);

    // Ambil daftar tahun dari server
    const resYear = await axios.get(`http://127.0.0.1:8000/api/get-year`);
    const years = resYear.data.data;

    // Isi elemen select dengan daftar tahun
    years.forEach((item) => {
        var option = document.createElement("option");
        option.value = item.year;
        option.text = item.year;
        tahun.appendChild(option);
    });

    // Panggil fungsi untuk menggambar grafik dengan tahun awal
    const initialYear = years[0].year;
    drawChart(initialYear);
};

chart();
