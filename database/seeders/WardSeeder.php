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
        $city = City::firstOrCreate([
            'name' => 'TP Hồ Chí Minh',
        ]);

        $wards = [
            ['code' => 'HCMQ101', 'name' => 'Bến Nghé', 'district' => 'Quận 1'],
            ['code' => 'HCMQ102', 'name' => 'Bến Thành', 'district' => 'Quận 1'],
            ['code' => 'HCMQ103', 'name' => 'Tân Định', 'district' => 'Quận 1'],
            ['code' => 'HCMQ104', 'name' => 'Cầu Ông Lãnh', 'district' => 'Quận 1'],

            ['code' => 'HCMQ301', 'name' => 'Bàn Cờ', 'district' => 'Quận 3'],
            ['code' => 'HCMQ302', 'name' => 'Xuân Hòa', 'district' => 'Quận 3'],
            ['code' => 'HCMQ303', 'name' => 'Võ Thị Sáu', 'district' => 'Quận 3'],

            ['code' => 'HCMQ401', 'name' => 'Xóm Chiếu', 'district' => 'Quận 4'],
            ['code' => 'HCMQ402', 'name' => 'Khánh Hội', 'district' => 'Quận 4'],
            ['code' => 'HCMQ403', 'name' => 'Vĩnh Hội', 'district' => 'Quận 4'],

            ['code' => 'HCMQ501', 'name' => 'Chợ Quán', 'district' => 'Quận 5'],
            ['code' => 'HCMQ502', 'name' => 'An Đông', 'district' => 'Quận 5'],
            ['code' => 'HCMQ503', 'name' => 'Chợ Lớn', 'district' => 'Quận 5'],

            ['code' => 'HCMQ601', 'name' => 'Bình Tây', 'district' => 'Quận 6'],
            ['code' => 'HCMQ602', 'name' => 'Bình Phú', 'district' => 'Quận 6'],
            ['code' => 'HCMQ603', 'name' => 'Phú Lâm', 'district' => 'Quận 6'],
            ['code' => 'HCMQ604', 'name' => 'Phú Định', 'district' => 'Quận 6'],

            ['code' => 'HCMQ701', 'name' => 'Tân Mỹ', 'district' => 'Quận 7'],
            ['code' => 'HCMQ702', 'name' => 'Phú Mỹ', 'district' => 'Quận 7'],
            ['code' => 'HCMQ703', 'name' => 'Tân Thuận', 'district' => 'Quận 7'],
            ['code' => 'HCMQ704', 'name' => 'Tân Phong', 'district' => 'Quận 7'],

            ['code' => 'HCMQ801', 'name' => 'Chánh Hưng', 'district' => 'Quận 8'],
            ['code' => 'HCMQ802', 'name' => 'Bình Đông', 'district' => 'Quận 8'],
            ['code' => 'HCMQ803', 'name' => 'Phú Định', 'district' => 'Quận 8'],
            ['code' => 'HCMQ804', 'name' => 'Rạch Ông', 'district' => 'Quận 8'],

            ['code' => 'HCMQ1001', 'name' => 'Diên Hồng', 'district' => 'Quận 10'],
            ['code' => 'HCMQ1002', 'name' => 'Hòa Hưng', 'district' => 'Quận 10'],
            ['code' => 'HCMQ1003', 'name' => 'Vạn Hạnh', 'district' => 'Quận 10'],

            ['code' => 'HCMQ1101', 'name' => 'Phú Thọ', 'district' => 'Quận 11'],
            ['code' => 'HCMQ1102', 'name' => 'Bình Thới', 'district' => 'Quận 11'],
            ['code' => 'HCMQ1103', 'name' => 'Lạc Long Quân', 'district' => 'Quận 11'],

            ['code' => 'HCMQ1201', 'name' => 'Tân Thới Hiệp', 'district' => 'Quận 12'],
            ['code' => 'HCMQ1202', 'name' => 'Đông Hưng Thuận', 'district' => 'Quận 12'],
            ['code' => 'HCMQ1203', 'name' => 'Thạnh Lộc', 'district' => 'Quận 12'],
            ['code' => 'HCMQ1204', 'name' => 'An Phú Đông', 'district' => 'Quận 12'],
            ['code' => 'HCMQ1205', 'name' => 'Tân Chánh Hiệp', 'district' => 'Quận 12'],

            ['code' => 'HCMBT01', 'name' => 'Gia Định', 'district' => 'Bình Thạnh'],
            ['code' => 'HCMBT02', 'name' => 'Thạnh Mỹ Tây', 'district' => 'Bình Thạnh'],
            ['code' => 'HCMBT03', 'name' => 'Bình Quới', 'district' => 'Bình Thạnh'],
            ['code' => 'HCMBT04', 'name' => 'Thanh Đa', 'district' => 'Bình Thạnh'],
            ['code' => 'HCMBT05', 'name' => 'Phú Nhuận Bắc', 'district' => 'Bình Thạnh'],

            ['code' => 'HCMPN01', 'name' => 'Phú Nhuận', 'district' => 'Phú Nhuận'],
            ['code' => 'HCMPN02', 'name' => 'Cầu Kiệu', 'district' => 'Phú Nhuận'],
            ['code' => 'HCMPN03', 'name' => 'Đức Nhuận', 'district' => 'Phú Nhuận'],

            ['code' => 'HCMTB01', 'name' => 'Tân Sơn Hòa', 'district' => 'Tân Bình'],
            ['code' => 'HCMTB02', 'name' => 'Tân Sơn Nhì', 'district' => 'Tân Bình'],
            ['code' => 'HCMTB03', 'name' => 'Bảy Hiền', 'district' => 'Tân Bình'],
            ['code' => 'HCMTB04', 'name' => 'Tân Hòa', 'district' => 'Tân Bình'],
            ['code' => 'HCMTB05', 'name' => 'Tân Bình', 'district' => 'Tân Bình'],
            ['code' => 'HCMTB06', 'name' => 'Phú Thọ Hòa', 'district' => 'Tân Bình'],

            ['code' => 'HCMTF01', 'name' => 'Tân Phú', 'district' => 'Tân Phú'],
            ['code' => 'HCMTF02', 'name' => 'Phú Thọ Hòa', 'district' => 'Tân Phú'],
            ['code' => 'HCMTF03', 'name' => 'Sơn Kỳ', 'district' => 'Tân Phú'],
            ['code' => 'HCMTF04', 'name' => 'Tân Sơn Nhì', 'district' => 'Tân Phú'],
            ['code' => 'HCMTF05', 'name' => 'Hòa Thạnh', 'district' => 'Tân Phú'],

            ['code' => 'HCMGV01', 'name' => 'Gò Vấp', 'district' => 'Gò Vấp'],
            ['code' => 'HCMGV02', 'name' => 'An Nhơn', 'district' => 'Gò Vấp'],
            ['code' => 'HCMGV03', 'name' => 'Thông Tây Hội', 'district' => 'Gò Vấp'],
            ['code' => 'HCMGV04', 'name' => 'An Hội Tây', 'district' => 'Gò Vấp'],
            ['code' => 'HCMGV05', 'name' => 'Hạnh Thông', 'district' => 'Gò Vấp'],

            ['code' => 'HCMTD01', 'name' => 'Thủ Đức', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD02', 'name' => 'Hiệp Bình', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD03', 'name' => 'Tam Bình', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD04', 'name' => 'Linh Xuân', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD05', 'name' => 'Linh Trung', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD06', 'name' => 'Linh Chiểu', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD07', 'name' => 'Bình Thọ', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD08', 'name' => 'Trường Thọ', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD09', 'name' => 'Phước Long', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD10', 'name' => 'Tăng Nhơn Phú', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD11', 'name' => 'Long Trường', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD12', 'name' => 'Long Phước', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD13', 'name' => 'Long Bình', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD14', 'name' => 'An Khánh', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD15', 'name' => 'An Phú', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD16', 'name' => 'Thảo Điền', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD17', 'name' => 'Bình Trưng', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD18', 'name' => 'Cát Lái', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD19', 'name' => 'Thạnh Mỹ Lợi', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD20', 'name' => 'Phú Hữu', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD21', 'name' => 'Hiệp Phú', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD22', 'name' => 'Tân Phú', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD23', 'name' => 'Phước Bình', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD24', 'name' => 'Phước Long A', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD25', 'name' => 'Phước Long B', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD26', 'name' => 'Bình Chiểu', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD27', 'name' => 'Tam Phú', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD28', 'name' => 'Bình An', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD29', 'name' => 'An Lợi Đông', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD30', 'name' => 'Trường Thạnh', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD31', 'name' => 'Long Thạnh Mỹ', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD32', 'name' => 'Tăng Nhơn Phú A', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD33', 'name' => 'Tăng Nhơn Phú B', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD34', 'name' => 'Phú Thọ', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD35', 'name' => 'Long Bình Tân', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD36', 'name' => 'Hiệp Bình Chánh', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD37', 'name' => 'Linh Đông', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD38', 'name' => 'Linh Tây', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD39', 'name' => 'Bình Trưng Tây', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD40', 'name' => 'Bình Trưng Đông', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD41', 'name' => 'Cát Lái Đông', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD42', 'name' => 'An Phú Đông', 'district' => 'TP Thủ Đức'],
            ['code' => 'HCMTD43', 'name' => 'Trường Thọ Đông', 'district' => 'TP Thủ Đức'],
        ];

        foreach ($wards as $ward) {
            Ward::updateOrCreate(
                ['code' => $ward['code']],
                [
                    'city_id' => $city->id,
                    'name' => $ward['name'],
                    'district' => $ward['district'],
                ]
            );
        }
    }
}
