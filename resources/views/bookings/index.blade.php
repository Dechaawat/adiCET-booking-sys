<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="mb-4">Booking List</h1>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">Add New Booking</a>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Room</th>
                <th>Equipment</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->room->name ?? '-' }}</td>
                    <td>{{ $booking->equipment->name ?? '-' }}</td>
                    <td>{{ $booking->start_time }}</td>
                    <td>{{ $booking->end_time }}</td>
                    <td>
                        <span class="badge bg-{{ $booking->status === 'approved' ? 'success' : ($booking->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>{{ $booking->reason }}</td>
                    <td>
    @if ($booking->status === 'pending' && auth()->user()->role === 'admin')
        <!-- ปุ่ม Approve และ Reject เฉพาะ Admin -->
        <form action="{{ route('bookings.approve', $booking->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-success">Approve</button>
        </form>
        <form action="{{ route('bookings.reject', $booking->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
        </form>
    @endif

    <!-- ปุ่ม Edit และ Delete สำหรับทุกคน (ทั้ง Admin และ User) -->
    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>

    <!-- ปุ่ม View สำหรับทุกคน -->
    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a>
</td>


                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No Bookings Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
