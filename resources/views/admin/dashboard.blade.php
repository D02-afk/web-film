@extends('admin.layout')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
            <div class="text-3xl font-bold text-purple-400">{{ $stats['total_movies'] }}</div>
            <div class="text-gray-400">Tổng số phim</div>
        </div>
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
            <div class="text-3xl font-bold text-green-400">{{ $stats['total_users'] }}</div>
            <div class="text-gray-400">Người dùng</div>
        </div>
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
            <div class="text-3xl font-bold text-yellow-400">{{ $stats['pending_reports'] }}</div>
            <div class="text-gray-400">Báo lỗi chưa xử lý</div>
        </div>
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
            <div class="text-3xl font-bold text-blue-400">{{ number_format($stats['today_views']) }}</div>
            <div class="text-gray-400">Lượt xem hôm nay</div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4">Phim mới thêm</h2>
    <div class="bg-gray-800 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-6 py-4 text-left">Tên phim</th>
                    <th class="px-6 py-4 text-left">Năm</th>
                    <th class="px-6 py-4 text-left">Quốc gia</th>
                    <th class="px-6 py-4 text-left">Lượt xem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentMovies as $movie)
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="px-6 py-4">{{ $movie->title }}</td>
                    <td class="px-6 py-4">{{ $movie->year }}</td>
                    <td class="px-6 py-4">{{ $movie->country->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $movie->views }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection