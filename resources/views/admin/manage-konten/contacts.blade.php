@extends('layouts.admin-layout')

@section('title', 'Pesan Masuk')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-heading font-bold text-gray-900">Pesan Masuk</h1>
    <p class="text-gray-500 text-sm mt-1">Pesan dari pengunjung website melalui form kontak</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Pengirim</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Pesan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Tanggal</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($contacts as $contact)
                <tr class="hover:bg-gray-50/50 transition {{ $contact->status == 'unread' ? 'bg-blue-50/30' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-semibold text-sm
                                        {{ $contact->status == 'unread' ? 'bg-blue-100 text-blue-700' : 
                                           ($contact->status == 'read' ? 'bg-gray-100 text-gray-700' : 'bg-green-100 text-green-700') }}">
                                {{ strtoupper(substr($contact->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $contact->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $contact->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 hidden md:table-cell max-w-xs">
                        <p class="truncate">{{ Str::limit($contact->pesan, 60) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.manage-konten.contacts.mark', $contact) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" 
                                    class="text-xs border-0 rounded-lg py-1.5 px-3 font-medium cursor-pointer
                                           {{ $contact->status == 'unread' ? 'bg-blue-100 text-blue-700' : 
                                              ($contact->status == 'read' ? 'bg-gray-100 text-gray-700' : 'bg-green-100 text-green-700') }}">
                                <option value="unread" {{ $contact->status == 'unread' ? 'selected' : '' }}>Unread</option>
                                <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Replied</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 hidden lg:table-cell">{{ $contact->created_at->format('d M H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="mailto:{{ $contact->email }}" class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition" title="Balas Email">
                            <i class="fas fa-reply text-sm"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <i class="fas fa-envelope text-4xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-500">Belum ada pesan masuk</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $contacts->links() }}</div>
@endsection