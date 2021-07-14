<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Institution</th>
        <th>Passing Year</th>
        <th>Subject</th>
        <th>Highest level of education</th>
        <th>Teacher</th>
        <th>Years Teaching</th>
        <th>Teaching Institution</th>
        <th>School Type</th>
        <th>Classes</th>

    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->name }}</td>
            <td>{{ $invoice->gender }}</td>
            <td>{{ $invoice->dob }}</td>
            <td>{{ $invoice->phone }}</td>
            <td>{{ $invoice->email }}</td>
            <td>{{ $invoice->institution }}</td>
            <td>{{ $invoice->passing_year }}</td>
            <td>{{ $invoice->subject }}</td>
            <td>{{ $invoice->education_level }}</td>
            <td>{{ $invoice->is_teacher }}</td>
            <td>{{ $invoice->years_teaching }}</td>
            <td>{{ $invoice->teaching_institution }}</td>
            <td>{{ $invoice->school_type }}</td>
            <td>{{ $invoice->classes }}</td>
        </tr>
    @endforeach
    </tbody>
</table>