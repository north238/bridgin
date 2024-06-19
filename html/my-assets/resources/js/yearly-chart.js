import Chart from "chart.js/auto";

const yearlyChart = document.getElementById("yearly-chart");
const config = {
    type: "bar",
    data: {
        labels: labels,
        datasets: [
            {
                label: "資産",
                data: assetsDataArray,
                backgroundColor: "#22C55E",
                borderSkipped: false,
                barPercentage: 0.5,
                order: 2,
                datalabels: {
                    display: false,
                },
            },
            {
                label: "負債",
                data: debutDataArray,
                backgroundColor: "#F87171",
                borderSkipped: false,
                barPercentage: 0.5,
                order: 3,
                datalabels: {
                    display: false,
                },
            },
            {
                type: "line",
                label: "資産合計",
                data: yearlyDataArray,
                backgroundColor: "#FBBF24",
                borderWidth: 1,
                borderColor: "#FBBF24",
                pointStyle: "rect",
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: "#FBBF24",
                order: 1,
                datalabels: {
                    display: false,
                },
            },
        ],
    },
    options: {
        animation: false,
        normalized: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                title: {
                    display: true,
                    text: "年月",
                    font: 14,
                },
                grid: {
                    display: true,
                    drawOnChartArea: false,
                    drawTicks: true,
                    tickColor: "#000",
                },
                border: {
                    display: true,
                    color: "#000",
                    width: 0.5,
                },
            },
            y: {
                title: {
                    display: true,
                    text: "金額（千円）",
                    font: 14,
                },
                grid: {
                    color: function (context) {
                        if (context.tick.label === "0") {
                            return "#000";
                        } else {
                            return "#D3D3D3";
                        }
                    },
                    lineWidth: 0.5,
                    tickColor: "#000",
                },
                border: {
                    display: true,
                    color: "#000",
                    width: 0.5,
                },
                ticks: {
                    callback: function (val, index) {
                        if (val != 0) {
                            val = Math.floor(val / 1000);
                        }
                        return index % 2 === 0
                            ? this.getLabelForValue(val)
                            : "";
                    },
                },
            },
        },
        plugins: {
            legend: {
                position: "top",
                labels: {
                    font: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    borderRadius: 1,
                },
            },
            tooltip: {
                enabled: true,
                usePointStyle: true,
                callbacks: {
                    labelPointStyle: function (context) {
                        return {
                            pointStyle: "rect",
                        };
                    },
                    title: function (context) {
                        const data = context[0].dataset.label;
                        return data;
                    },
                    label: function (context) {
                        let label = "";
                        if (context) {
                            const amount = new Intl.NumberFormat("ja-JP", {
                                style: "currency",
                                currency: "JPY",
                            }).format(context.raw);
                            label = ["金額：" + amount];
                        }
                        return label;
                    },
                },
            },
        },
    },
};

function yearlyBarChart() {
    new Chart(yearlyChart, config);
}

function darkMode() {
    if (
        localStorage.getItem("color-theme") === "dark" ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                console.log('hoge');
            }
}
darkMode();

window.addEventListener("DOMContentLoaded", () => {
    yearlyBarChart();
});