<h2>Khách hàng mới đăng ký dịch vụ</h2>
<p><strong>Họ tên:</strong> {{ $data['name'] }}</p>
<p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
<p><strong>Địa chỉ:</strong> {{ $data['address'] }}</p>
<p><strong>Dịch vụ:</strong> {{ $data['service'] }}</p>
<p><strong>Đăng ký từ website:</strong> <a href="{{ $data['from_page'] }}">{{ $data['from_page'] }}<</a></p>
<p><strong>Xem chi tiết tại đây:</strong> <a href="https://docs.google.com/spreadsheets/d/{{ site_config('google_spreadsheet_id') }}">https://docs.google.com/spreadsheets/d/{{ site_config('google_spreadsheet_id') }}</a></p>
