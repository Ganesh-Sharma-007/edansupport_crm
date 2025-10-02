<div class="table-responsive">
    <table class="table table-sm align-middle">
        <thead class="table-light">
            <tr>
                <th>Week Start</th>
                <th>Total Hours</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
                <th>Sun</th>
            </tr>
        </thead>
        <tbody>
            {{-- Dummy row until dynamic data --}}
            <tr>
                <td>{{ now()->startOfWeek()->format('d M Y') }}</td>
                <td>37.5</td>
                <td>7.5</td>
                <td>7.5</td>
                <td>7.5</td>
                <td>7.5</td>
                <td>7.5</td>
                <td>0</td>
                <td>0</td>
            </tr>
        </tbody>
    </table>
</div>