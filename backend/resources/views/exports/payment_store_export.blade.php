<table>

    <thead>

        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Amount before deduction of commission</th>
            <th>Commission</th>
            <th>Amount after deduction of commission</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody style="text-align: center">
        @foreach ($orders as $item)
            <tr>
                @php
                    $refund_period = setting('refund_period');
                    $refund_period = $refund_period ?: 10;
                    $date = $item->created_at->addDays($refund_period);
                    $subTotal += $item->subtotal;
                    $application_dues += $item->application_dues;
                    $total += $item->subtotal - $item->application_dues;
                @endphp
                <td>{{ $item->id }}</td>
                <td>{{ $item->store?->name }}</td>
                <td>{{ $item->subtotal }}</td>
                <td>{{ $item->application_dues_percentage }}</td>
                <td>{{ $item->application_dues }}</td>
                <td>{{ number_format((float) ($item->subtotal - $item->application_dues), 2, '.', '') }}</td>
                <td>{{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($date)->translatedFormat('H:i') }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total :</td>
            <td></td>
            <td>{{ $subTotal }}</td>
            <td></td>
            <td>{{ $application_dues }}</td>
            <td>{{ number_format((float) $total, 2, '.', '') }}</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
