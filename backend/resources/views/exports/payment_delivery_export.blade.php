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
                    $subTotal += $item->delivery_charge;
                    $application_dues += $item->application_dues;
                    $total += $item->delivery_charge - $item->application_delivery_dues;
                @endphp
                <td>{{ $item->id }}</td>
                <td>{{ $item->delivery?->name }}</td>
                <td>{{ $item->delivery_charge }}</td>
                <td>{{ $item->application_delivery_dues_percentage }}</td>
                <td>{{ $item->application_delivery_dues }}</td>
                <td>{{ number_format((float) ($item->delivery_charge - $item->application_delivery_dues), 2, '.', '') }}
                </td>
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
