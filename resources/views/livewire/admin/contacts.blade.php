<div class="space-y-8">
    <div class="flex justify-between">
        <h2 class="font-heading text-2xl font-bold text-gray-800">Kontakti</h2>
    </div>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
        <thead class="bg-gray-100 text-gray-700 font-heading text-lg">
            <tr>
                <th class="py-3 px-6 text-left">R.br.</th>
                <th class="py-3 px-6 text-left">Email</th>

            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-6">{{ $contacts->firstItem() + $loop->index}}</td>
                <td class="py-3 px-6">{{ $contact->email}}</td>


            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $contacts->links() }}
    </div>
</div>