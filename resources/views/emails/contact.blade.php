<table class="w-full max-w-xl mx-auto">
    <tr>
        <td class="bg-gray-100 text-gray-700 px-6 py-4">
            <h2 class="text-lg font-bold">Contact Form Submission</h2>
            <p><strong>Name:</strong> {{ $details['name'] }}</p>
            <p><strong>Email:</strong> {{ $details['email'] }}</p>
            <p><strong>Message:</strong></p>
            <p>{{ $details['message'] }}</p>
        </td>
    </tr>
</table>