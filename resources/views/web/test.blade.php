<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Listesi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 50%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            padding: 8px 12px;
            margin: 2px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Kategori Listesi</h2>
    
    <table>
        <tr>
            <th>Kategori ID</th>
            <th>Kategori Adı</th>
        </tr>
        @foreach ($categoryData as $category)
            <tr>
                <td>{{ $category['id'] }}</td>
                <td>{{ htmlspecialchars($category['name']) }}</td>
            </tr>
        @endforeach
    </table>

    <!-- Sayfalama -->
    <div class="pagination">
        @if ($currentPage > 1)
            <a href="?page={{ $currentPage - 1 }}">Önceki</a>
        @endif

        @for ($i = 1; $i <= $totalPages; $i++)
            <a href="?page={{ $i }}">{{ $i }}</a>
        @endfor

        @if ($currentPage < $totalPages)
            <a href="?page={{ $currentPage + 1 }}">Sonraki</a>
        @endif
    </div>

</body>
</html>
