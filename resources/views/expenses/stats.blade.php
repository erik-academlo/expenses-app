@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <canvas id="myChart"></canvas>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        axios.get('/api/v1/expenses/count')
            .then(response => {
                const labels = Object.keys(response.data);
                const data = Object.values(response.data);
                setChart(labels, data);
            }).catch(() => {
                alert('No pudimos cargar los gastos');
            });

        function setChart(labels, data) {
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '',
                        data: data,
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
        }
    </script>
@endsection
