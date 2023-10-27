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

        const user = await axios.get(`api/get-apply?filter_year=${selectedYear}`
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

    // console.log('result',tahun);
    // Tambahkan event listener untuk perubahan tahun
    tahun.addEventListener("change", changeYear);

    // Ambil daftar tahun dari server
    const resYear = await axios.get(`/api/get-year`);
    const years = resYear.data.data;

    // Isi elemen select dengan daftar tahun
    const year = new Date();
    const initialYear = year.getFullYear();
    years.forEach((item) => {
        var option = document.createElement("option");
        option.value = item.year;
        option.text = item.year;
        tahun.appendChild(option);
        if (parseInt(option.value) === initialYear) {
            option.selected = true;
        }
    });

    // Panggil fungsi untuk menggambar grafik dengan tahun awal
    drawChart(initialYear);
};
chart();
const chartApply = async () => {
    const resApply = await axios.get("/api/get-data-apply"
    );
    const { total_ditolak, total_lulus, total_pendaftar } =
        resApply.data.result;

    // applyData,map((item)=>item.total)
    const apply = document.getElementById("charts-apply");
    const data = {
        labels: ["Ditolak", "Lulus", "Pending"],
        datasets: [
            {
                label: "My First Dataset",
                data: [total_ditolak, total_lulus, total_pendaftar],
                backgroundColor: [
                    "#d05f5f", // Merah
                    "#5FD068", // Hijau yang kurang cerah
                    "#5f87d0", // Biru
                ],
                hoverOffset: 4,
            },
        ],
    };
    let applyChart = new Chart(apply, {
        type: "doughnut",
        data: data,
    });
};

chartApply();
