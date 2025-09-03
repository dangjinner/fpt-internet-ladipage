<?php

namespace App\Jobs;

use App\Mail\RegisterFptInternetMail;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RegisterFptInternet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    private $sheetName;
    private $sheetId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->sheetName = site_config('google_sheet_name');
        $this->sheetId = site_config('google_spreadsheet_id');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 1. Gửi dữ liệu lên Google Sheet
        $this->appendToGoogleSheet($this->data);

        // 2. Gửi email thông báo
        $emails = site_config('notify_emails');
        $emailArray = array_filter(array_map('trim', preg_split('/[,;]+/', $emails)));

        Mail::to($emailArray)->send(new RegisterFptInternetMail($this->data));
    }

    private function appendToGoogleSheet($contact)
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-service-account.json'));
        $client->addScope(Sheets::SPREADSHEETS);

        $service = new Sheets($client);

        $range = $this->sheetName . '!A:L';
        $values = [
            [
                $contact['time'],
                $contact['name'],
                $contact['phone'],
                $contact['service'],
                $contact['address'],
                $contact['ip'],
                $contact['utm_source'] ?? '',
                $contact['utm_campaign'] ?? '',
                $contact['utm_medium'] ?? '',
                $contact['utm_content'] ?? '',
                $contact['utm_term'] ?? '',
                $contact['from_page'],
            ]
        ];

        $body = new Sheets\ValueRange(['values' => $values]);
        $params = ['valueInputOption' => 'RAW'];

        $service->spreadsheets_values->append($this->sheetId, $range, $body, $params);
    }
}
