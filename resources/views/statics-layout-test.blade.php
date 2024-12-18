@extends('Admin.Layout.Layout')
@section('content')

    <div class="wrapper">
        <div style="display: flex; justify-content: space-around; gap: 20px;">
            <div class="card-item">
                <img alt="Energy icon" height="30" src="https://storage.googleapis.com/a1aa/image/KamAa9fe22p3Dk3zY3UGdmmF0OkvgiefGSeZ1twXvX2HfEAfJA.jpg" width="30"/>
                <h3>Energy</h3>
                <div class="progress-ring">
                    <svg>
                        <circle class="background" cx="50" cy="50" r="45"></circle>
                        <circle class="progress-meter" cx="50" cy="50" r="45" stroke="#007bff" stroke-dasharray="282.743" stroke-dashoffset="155.509"></circle>
                    </svg>
                    <div class="percentage">45%</div>
                </div>
            </div>

            <div class="card-item">
                <img alt="Range icon" height="30" src="https://storage.googleapis.com/a1aa/image/lzswf6e1TGtXgUe7xkho4phFd7nSuMJfmwSC4FVgPJraPBwPB.jpg" width="30"/>
                <h3>Range</h3>
                <div class="progress-ring">
                    <svg>
                        <circle class="background" cx="50" cy="50" r="45"></circle>
                        <circle class="progress-meter" cx="50" cy="50" r="45" stroke="#ff4d4d" stroke-dasharray="282.743" stroke-dashoffset="120.0"></circle>
                    </svg>
                    <div class="percentage">157k</div>
                </div>
            </div>

            <div class="card-item">
                <img alt="Break Fluid icon" height="30" src="https://storage.googleapis.com/a1aa/image/PsJGBV1wAeTJL6pnw2sLkqd7RNfJg44g3edf3J2OCJtWPBwPB.jpg" width="30"/>
                <h3>Break Fluid</h3>
                <div class="progress-ring">
                    <svg>
                        <circle class="background" cx="50" cy="50" r="45"></circle>
                        <circle class="progress-meter" cx="50" cy="50" r="45" stroke="#7e3af2" stroke-dasharray="282.743" stroke-dashoffset="257.299"></circle>
                    </svg>
                    <div class="percentage">9%</div>
                </div>
            </div>

            <div class="card-item">
                <img alt="Tire Wear icon" height="30" src="https://storage.googleapis.com/a1aa/image/4Jlf9fMJe1Bjjo0gDry06x1AyZEB4AtgvZxhbfe4M06meEAfJA.jpg" width="30"/>
                <h3>Tire Wear</h3>
                <div class="progress-ring">
                    <svg>
                        <circle class="background" cx="50" cy="50" r="45"></circle>
                        <circle class="progress-meter" cx="50" cy="50" r="45" stroke="#dcdcdc" stroke-dasharray="282.743" stroke-dashoffset="211.857"></circle>
                    </svg>
                    <div class="percentage">25%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard">
  <div class="chart-card">
    <h3>Miles Statistics</h3>
    <div class="tabs">
      <button class="active">Day</button>
      <button>Week</button>
      <button>Month</button>
    </div>
    <div class="chart">
      <img alt="Bar chart showing miles statistics" height="200" src="https://storage.googleapis.com/a1aa/image/UZjspCBe4VXrYyAAfAeZ0wlTDjEDzmNNsT2WLJNZSHbknA4nA.jpg" width="400"/>
    </div>
  </div>
  <div class="chart-card">
    <h3>Car Statistics</h3>
    <div class="tabs">
      <button class="active">Day</button>
      <button>Week</button>
      <button>Month</button>
    </div>
    <div class="chart">
      <img alt="Line chart showing car statistics" height="200" src="https://storage.googleapis.com/a1aa/image/2uS6e4MUMXUzKKFjPX3XwFdn8veXVtCmT9mjzpAU60V3TA8TA.jpg" width="400"/>
    </div>
  </div>
</div>


@endsection
