<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Ward;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataPath = database_path('seeders/data/vn_only_simplified_json_generated_data_vn_units.json');
        if (!is_file($dataPath)) {
            throw new \RuntimeException('Missing VN administrative data JSON: ' . $dataPath);
        }

        $data = json_decode(file_get_contents($dataPath), true);

        if (!is_array($data)) {
            throw new \RuntimeException('Unable to read VN administrative data JSON.');
        }

        foreach ($data as $province) {
            $cityName = $this->stripAdministrativePrefix($province['FullName'] ?? '');
            if ($cityName === '') {
                continue;
            }

            $city = City::firstOrCreate([
                'name' => $cityName,
            ]);

            foreach (($province['Wards'] ?? []) as $ward) {
                $wardCode = $ward['Code'] ?? '';
                $wardName = $this->stripAdministrativePrefix($ward['FullName'] ?? '');
                if ($wardCode === '' || $wardName === '') {
                    continue;
                }

                Ward::updateOrCreate(
                    ['code' => $wardCode],
                    [
                        'city_id' => $city->id,
                        'name' => $wardName,
                        'district' => null,
                    ]
                );
            }
        }
    }

    private function stripAdministrativePrefix(string $fullName): string
    {
        $prefixes = [
            'Thành phố ',
            'Tỉnh ',
            'Phường ',
            'Xã ',
            'Thị trấn ',
            'Đặc khu ',
        ];

        foreach ($prefixes as $prefix) {
            if (str_starts_with($fullName, $prefix)) {
                return trim(substr($fullName, strlen($prefix)));
            }
        }

        return $fullName;
    }
}
