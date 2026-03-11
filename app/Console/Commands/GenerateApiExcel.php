<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class GenerateApiExcel extends Command
{
    protected $signature = 'api:generate-excel {--output=api_routes.xlsx : Output file path}';
    protected $description = 'Generate an Excel file containing all API routes with sample input/output data';

    private function getSampleData(): array
    {
        return [
            'auth/login' => [
                'POST' => [
                    'input' => json_encode(['email' => 'user@example.com', 'password' => 'password123'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                    'output' => json_encode(['refresh_token' => 'abc123...', 'role_id' => 1, 'token_type' => 'bearer', 'access_token' => 'eyJ...'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ],
            ],
            'auth/register' => [
                'POST' => [
                    'input' => json_encode(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password123'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                    'output' => json_encode(['data' => ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com']], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ],
            ],
            'auth/refresh-token' => [
                'POST' => [
                    'input' => json_encode(['refresh_token' => 'abc123def456...'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                    'output' => json_encode(['token' => 'eyJ...new', 'refreshToken' => 'xyz789...'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ],
            ],
            'auth/logout' => [
                'POST' => [
                    'input' => 'Header: Authorization: Bearer {token}',
                    'output' => json_encode(['message' => 'Successfully logged out'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ],
            ],
            'auth/user' => [
                'GET' => [
                    'input' => 'Header: Authorization: Bearer {token}',
                    'output' => json_encode(['id' => 1, 'uuid' => 'uuid-string', 'name' => 'John', 'email' => 'john@example.com', 'phone' => '0912345678', 'gender' => 'male', 'status' => 'active', 'image_url' => 'https://...', 'role' => ['id' => 1, 'name' => 'admin']], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ],
                'PUT' => [
                    'input' => json_encode(['name' => 'John Updated', 'phone' => '0987654321', 'gender' => 'male', 'image' => '(file upload)'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                    'output' => json_encode(['data' => ['id' => 1, 'name' => 'John Updated', 'phone' => '0987654321']], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ],
            ],
            'auth/users' => [
                'GET' => [
                    'input' => 'Query: ?page=1&per_page=10',
                    'output' => json_encode(['items' => [['id' => 1, 'name' => 'John', 'email' => 'john@example.com']], 'paginate' => ['current_page' => 1, 'per_page' => 10, 'total' => 50]], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ],
            ],
            'cart/add' => [
                'POST' => [
                    'input' => json_encode(['branch_product_id' => 1, 'quantity' => 2], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                    'output' => json_encode(['data' => ['id' => 1, 'cart_id' => 1, 'branch_product_id' => 1, 'quantity' => 2]], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                ],
            ],
            'colors' => $this->buildCrudSamples([
                'store_input' => ['name' => 'Đỏ', 'code' => '#FF0000'],
                'update_input' => ['name' => 'Đỏ đậm', 'code' => '#CC0000'],
                'resource' => ['id' => 1, 'name' => 'Đỏ', 'code' => '#FF0000'],
            ]),
            'branches' => $this->buildCrudSamples([
                'store_input' => ['name' => 'Chi nhánh Quận 1', 'detail' => '123 Nguyễn Huệ', 'city_id' => 1, 'ward_id' => 1],
                'update_input' => ['name' => 'Chi nhánh Quận 1 Updated', 'detail' => '456 Lê Lợi'],
                'resource' => ['id' => 1, 'name' => 'Chi nhánh Quận 1', 'detail' => '123 Nguyễn Huệ', 'city' => ['id' => 1, 'name' => 'TP.HCM'], 'ward' => ['id' => 1, 'name' => 'Phường Bến Nghé']],
            ]),
            'employees' => $this->buildCrudSamples([
                'store_input' => ['user_id' => 1, 'branch_id' => 1, 'position' => 'Nhân viên bán hàng'],
                'update_input' => ['position' => 'Quản lý'],
                'resource' => ['id' => 1, 'user_id' => 1, 'branch_id' => 1, 'position' => 'Nhân viên bán hàng'],
            ]),
            'brands' => $this->buildCrudSamples([
                'store_input' => ['name' => 'Apple'],
                'update_input' => ['name' => 'Samsung'],
                'resource' => ['id' => 1, 'name' => 'Apple', 'slug' => 'apple'],
            ]),
            'categories' => $this->buildCrudSamples([
                'store_input' => ['name' => 'Điện thoại', 'parent_id' => null],
                'update_input' => ['name' => 'Smartphone'],
                'resource' => ['id' => 1, 'name' => 'Điện thoại', 'slug' => 'dien-thoai', 'parent_id' => null],
            ]),
            'tags' => $this->buildCrudSamples([
                'store_input' => ['name' => 'Hot Sale', 'slug' => 'hot-sale'],
                'update_input' => ['name' => 'Best Seller', 'slug' => 'best-seller'],
                'resource' => ['id' => 1, 'name' => 'Hot Sale', 'slug' => 'hot-sale'],
            ]),
            'attributes' => $this->buildCrudSamples([
                'store_input' => ['name' => 'RAM'],
                'update_input' => ['name' => 'Bộ nhớ RAM'],
                'resource' => ['id' => 1, 'name' => 'RAM'],
            ]),
            'products' => $this->buildCrudSamples([
                'store_input' => ['name' => 'iPhone 16 Pro Max', 'description' => 'Mô tả sản phẩm', 'brand_id' => 1, 'category_id' => 1, 'tag_ids' => [1, 2], 'attributes' => [['attribute_id' => 1, 'value' => '8GB']], 'image_files' => '(file upload)'],
                'update_input' => ['name' => 'iPhone 16 Pro Max Updated', 'description' => 'Mô tả mới'],
                'resource' => ['id' => 1, 'name' => 'iPhone 16 Pro Max', 'slug' => 'iphone-16-pro-max', 'description' => 'Mô tả', 'brand_id' => 1, 'category_id' => 1, 'brand' => ['id' => 1, 'name' => 'Apple'], 'category' => ['id' => 1, 'name' => 'Điện thoại'], 'images' => [], 'tags' => []],
            ]),
            'storages' => $this->buildCrudSamples([
                'store_input' => ['label' => '256GB'],
                'update_input' => ['label' => '512GB'],
                'resource' => ['id' => 1, 'label' => '256GB'],
            ]),
            'product-variants' => $this->buildCrudSamples([
                'store_input' => ['product_id' => 1, 'color_id' => 1, 'storage_id' => 1],
                'update_input' => ['color_id' => 2, 'storage_id' => 2],
                'resource' => ['id' => 1, 'product_id' => 1, 'color_id' => 1, 'storage_id' => 1, 'sku' => 'SKU-001'],
            ]),
            'branch-products' => $this->buildCrudSamples([
                'store_input' => ['branch_id' => 1, 'product_variant_id' => 1, 'price' => 29990000],
                'update_input' => ['price' => 27990000, 'status' => 'active'],
                'resource' => ['id' => 1, 'branch_id' => 1, 'product_variant_id' => 1, 'price' => 29990000, 'stock' => 100, 'status' => 'active'],
            ]),
            'inventory-types' => $this->buildCrudSamples([
                'store_input' => ['code' => 'IMPORT', 'name' => 'Nhập kho'],
                'update_input' => ['name' => 'Nhập hàng'],
                'resource' => ['id' => 1, 'code' => 'IMPORT', 'name' => 'Nhập kho'],
            ]),
            'inventory-transactions' => $this->buildCrudSamples([
                'store_input' => ['branch_id' => 1, 'inventory_type_id' => 1, 'code' => 'TX-001', 'note' => 'Nhập hàng mới', 'items' => [['branch_product_id' => 1, 'quantity' => 10, 'unit_price' => 25000000]]],
                'update_input' => ['note' => 'Cập nhật ghi chú', 'items' => [['branch_product_id' => 1, 'quantity' => 15, 'unit_price' => 25000000]]],
                'resource' => ['id' => 1, 'branch_id' => 1, 'inventory_type_id' => 1, 'code' => 'TX-001', 'note' => 'Nhập hàng mới', 'items' => [['id' => 1, 'branch_product_id' => 1, 'quantity' => 10, 'unit_price' => 25000000]]],
            ]),
            'cities' => $this->buildCrudSamples([
                'store_input' => ['name' => 'TP. Hồ Chí Minh'],
                'update_input' => ['name' => 'Hà Nội'],
                'resource' => ['id' => 1, 'name' => 'TP. Hồ Chí Minh'],
            ]),
            'wards' => $this->buildCrudSamples([
                'store_input' => ['district_id' => 1, 'name' => 'Phường Bến Nghé'],
                'update_input' => ['name' => 'Phường Bến Thành'],
                'resource' => ['id' => 1, 'district_id' => 1, 'name' => 'Phường Bến Nghé'],
            ]),
            'user-addresses' => $this->buildCrudSamples([
                'store_input' => ['city_id' => 1, 'ward_id' => 1, 'detail' => '123 Nguyễn Huệ', 'receiver_name' => 'Nguyễn Văn A', 'phone' => '0912345678', 'is_default' => true],
                'update_input' => ['detail' => '456 Lê Lợi', 'phone' => '0987654321'],
                'resource' => ['id' => 1, 'user_id' => 1, 'city_id' => 1, 'ward_id' => 1, 'detail' => '123 Nguyễn Huệ', 'receiver_name' => 'Nguyễn Văn A', 'phone' => '0912345678', 'is_default' => true],
            ]),
        ];
    }

    private function buildCrudSamples(array $data): array
    {
        $resource = $data['resource'];
        $listOutput = json_encode([
            'items' => [$resource],
            'paginate' => ['current_page' => 1, 'per_page' => 10, 'total' => 50],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $singleOutput = json_encode(['data' => $resource], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return [
            'index' => ['input' => 'Query: ?page=1&per_page=10', 'output' => $listOutput],
            'search' => ['input' => 'Query: ?keyword=abc&page=1&per_page=10', 'output' => $listOutput],
            'show' => ['input' => 'Path param: {id} = 1', 'output' => $singleOutput],
            'store' => ['input' => json_encode($data['store_input'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'output' => $singleOutput],
            'update' => ['input' => json_encode($data['update_input'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 'output' => $singleOutput],
            'destroy' => ['input' => 'Path param: {id} = 1', 'output' => json_encode(['success' => true], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)],
        ];
    }

    private function colLetter(int $index): string
    {
        return Coordinate::stringFromColumnIndex($index + 1);
    }

    public function handle(): int
    {
        $outputPath = $this->option('output');
        if (!str_contains($outputPath, '/') && !str_contains($outputPath, '\\')) {
            $outputPath = storage_path('app/' . $outputPath);
        }

        $routes = $this->collectApiRoutes();
        $sampleData = $this->getSampleData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('API Routes');

        // Headers
        $headers = ['#', 'Method', 'URI', 'Middleware', 'Controller', 'Action', 'Auth Required', 'Admin Only', 'Sample Input', 'Sample Output'];
        foreach ($headers as $col => $header) {
            $sheet->getCell($this->colLetter($col) . '1')->setValue($header);
        }

        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2F5496']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $methodColors = [
            'GET' => 'FF27AE60',
            'POST' => 'FFE67E22',
            'PUT' => 'FF2980B9',
            'DELETE' => 'FFE74C3C',
            'PATCH' => 'FF8E44AD',
        ];

        $row = 2;
        $idx = 1;
        $currentGroup = '';

        foreach ($routes as $route) {
            $uri = $route['uri'];

            // Group separator row
            $group = explode('/', $uri)[1] ?? $uri;
            if ($group !== $currentGroup) {
                $currentGroup = $group;
                $sheet->getCell("A{$row}")->setValue(strtoupper($group));
                $sheet->mergeCells("A{$row}:J{$row}");
                $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF34495E']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $row++;
            }

            $method = $route['method'];
            [$sampleInput, $sampleOutput] = $this->matchSampleData($sampleData, $uri, $method, $route['action_name']);

            $rowData = [
                $idx,
                $method,
                $uri,
                implode(', ', $route['middleware']),
                $route['controller'],
                $route['action_name'],
                $route['requires_auth'] ? 'Yes' : 'No',
                $route['admin_only'] ? 'Yes' : 'No',
                $sampleInput,
                $sampleOutput,
            ];

            foreach ($rowData as $col => $value) {
                $sheet->getCell($this->colLetter($col) . $row)->setValue($value);
            }

            // Method color
            if (isset($methodColors[$method])) {
                $sheet->getStyle("B{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $methodColors[$method]]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }

            // Auth/Admin highlights
            if ($route['requires_auth']) {
                $sheet->getStyle("G{$row}")->applyFromArray([
                    'font' => ['color' => ['argb' => 'FFE67E22'], 'bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }
            if ($route['admin_only']) {
                $sheet->getStyle("H{$row}")->applyFromArray([
                    'font' => ['color' => ['argb' => 'FFE74C3C'], 'bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }

            // Alternating row color
            if ($idx % 2 === 0) {
                $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF2F2F2']],
                ]);
                if (isset($methodColors[$method])) {
                    $sheet->getStyle("B{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $methodColors[$method]]],
                    ]);
                }
            }

            // Borders + wrap
            $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFD5D5D5']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
            ]);

            $row++;
            $idx++;
        }

        // Column widths
        $widths = ['A' => 5, 'B' => 10, 'C' => 40, 'D' => 25, 'E' => 45, 'F' => 12, 'G' => 14, 'H' => 12, 'I' => 50, 'J' => 55];
        foreach ($widths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        $sheet->freezePane('A2');
        $sheet->setAutoFilter("A1:J1");

        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($outputPath);

        $this->info("API Excel generated: {$outputPath}");
        $this->info("Total routes: " . ($idx - 1));

        return Command::SUCCESS;
    }

    private function collectApiRoutes(): array
    {
        $routes = [];

        foreach (Route::getRoutes() as $route) {
            $uri = $route->uri();
            if (!str_starts_with($uri, 'api/')) {
                continue;
            }
            if (str_contains($uri, 'sanctum') || str_contains($uri, 'swagger') || str_contains($uri, 'api-docs')) {
                continue;
            }

            $methods = array_diff($route->methods(), ['HEAD']);
            $middleware = $route->middleware();
            $action = $route->getAction();
            $controller = $action['controller'] ?? 'Closure';

            $controllerName = $controller;
            $actionName = '';
            if (is_string($controller) && str_contains($controller, '@')) {
                [$controllerClass, $actionName] = explode('@', $controller);
                $controllerName = class_basename($controllerClass) . '@' . $actionName;
            }

            $requiresAuth = in_array('auth:api', $middleware) || in_array('auth:sanctum', $middleware);
            $adminOnly = in_array('admin', $middleware);

            foreach ($methods as $method) {
                $routes[] = [
                    'method' => $method,
                    'uri' => '/' . $uri,
                    'middleware' => $middleware,
                    'controller' => $controllerName,
                    'action_name' => $actionName,
                    'requires_auth' => $requiresAuth,
                    'admin_only' => $adminOnly,
                ];
            }
        }

        usort($routes, function ($a, $b) {
            $cmp = strcmp($a['uri'], $b['uri']);
            if ($cmp !== 0) return $cmp;
            $order = ['GET' => 0, 'POST' => 1, 'PUT' => 2, 'PATCH' => 3, 'DELETE' => 4];
            return ($order[$a['method']] ?? 99) - ($order[$b['method']] ?? 99);
        });

        return $routes;
    }

    private function matchSampleData(array $sampleData, string $uri, string $method, string $actionName): array
    {
        $cleanUri = preg_replace('#^/api/#', '', $uri);

        // Direct match (auth, cart)
        if (isset($sampleData[$cleanUri][$method])) {
            return [$sampleData[$cleanUri][$method]['input'], $sampleData[$cleanUri][$method]['output']];
        }

        // CRUD match
        $prefix = preg_replace('#/\{[^}]+\}$#', '', $cleanUri);
        if (isset($sampleData[$prefix][$actionName])) {
            return [$sampleData[$prefix][$actionName]['input'], $sampleData[$prefix][$actionName]['output']];
        }

        return ['', ''];
    }
}
