@extends('layouts.user_type.auth')

@section('css')
  <style>
    @media print {
      @page {
        size: landscape;
      }
      #contentNotPrint {
        display: none;
      }
    }
  </style>
@endsection

@section('content')
@if(session('success') || session('error'))
<div class="toast align-items-center text-white {{session('success') ? "bg-success" : "bg-danger" }} show border-0 top-5 end-3 position-absolute" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 100">
    <div class="d-flex">
    <div class="toast-body">
        {{session('success')}} {{session('error')}}
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
@endif

<div>
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 mx-4">
        <div class="w-100">
          <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
              <h6>Grafik Persentase Pelatihan Karyawan {{$year}}</h6>
              <div class="d-flex flex-row mx-4">
                <button id="contentNotPrint" class="btn bg-gradient-primary btn-sm " onclick="printContent()">Cetak</button>
                <a id="contentNotPrint" class="btn bg-gradient-info btn-sm ms-2" href="{{route('pelatihan.periode',$year)}}">Kembali</a>
              </div>
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
          <div class="row px-2">
            <div class="col py-3">
              <div class="card bg-gradient-info border-0 h-100">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="text-white mb-2">Terpenuhi</h5>
                      <span class="text-white font-weight-bold font-size-h1">
                        {{$terpenuhi}}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col py-3">
              <div class="card bg-gradient-success border-0 h-100">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="text-white mb-2">Belum Terpenuhi</h5>
                      <span class="text-white font-weight-bold font-size-h1">
                        {{$tidak_terpenuhi}}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
  <script type="text/javascript">
      function printContent() {
          // Print the content
          window.print();
      }
    window.onload = function() {
        var ctx2 = document.getElementById("chart-line").getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: {!! json_encode($labels) !!},
          datasets: [{
              label: "Jumlah Karyawan",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: {!! json_encode($counts) !!},
              maxBarThickness: 6

            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              type: 'linear',
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                stepSize: 1,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
    </script>
@endpush