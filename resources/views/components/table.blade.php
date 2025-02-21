@props(['tableClasses' => 'table table-striped', 'headers' => [], 'rows' => []])

<table class="{{ $tableClasses }}" style="width: 100%">
    <thead>
        <tr>
            @foreach ($headers as $header)
                <th scope="col">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($rows as $row)
            <tr>
                <td>{{ $row->title }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->start_time }}</td>
                <td>{{ $row->end_time }}</td>
                <td>{{ $row->capacity }}</td>
                <td>
                    <a href="{{ route('events.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('events.destroy', $row->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"  >Delete</button>

                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($headers) }}" class="text-center">No records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
