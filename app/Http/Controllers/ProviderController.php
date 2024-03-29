<?php

namespace App\Http\Controllers;

use App\Mail\ProjectAddedMail;
use App\Models\MailTemplate;
use App\Models\Project;
use App\Models\Provider;
use App\Mail\ProviderRequestMail;
use Illuminate\Support\Facades\Mail;

class ProviderController extends Controller
{
    protected $table = 'providers';

    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('admin') || $user->hasRole('authorizator')) {
            return response()->json(
                [
                    'success' => true,
                    'providers' => Provider::all()
                ]
            );
        }
    }

    public function sendMailsByQueue()
    {
        $mails = json_decode(request('mails'));
        $project_id = request('project_id');

        try {
            foreach ($mails as $mail) {
                $provider = Provider::find($mail->provider_id);
                Mail::to($provider->email)->queue(new ProviderRequestMail($mail->body));
            }
            return response()->json(
                [
                    'success' => true
                ]
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $error->getMessage()
                ]
            );
        }
    }

    public function getTemplate()
    {
        $provider_id = request('provider_id');
        $project_id = request('project_id');

        if (empty($provider_id) || empty($project_id)) {
            return response()->json(
                [
                    'success' => false,
                    'error' => 'provider or project id is empty'
                ]
            );
        }
        $provider = new Provider;
        $project = new Project;
        try {
            $provider->find($provider_id);
            $project->find($project_id);

            $manager = 'TODO!!';

            $template = $provider->template;

            if (!$template) {
                $template = MailTemplate::where('provider_id', 0)->first();

                $dictionary = [
                    '#subject#' => $template['subject'],
                    '#responsible#' => $provider->find($provider_id)->responsible,
                    '#manager_name#' => $manager,
                ];

                return response()->json(
                    [
                        'success' => true,
                        'template' => $template,
                        'default' => false,
                        'dictionary' => $dictionary
                    ]
                );
            }
            $dictionary = [
                '#subject#' => $template['subject'],
                '#responsible#' => $provider->responsible,
                '#manager_name#' => $manager
            ];
            return response()->json(
                [
                    'success' => true,
                    'template' => $template,
                    'default' => false,
                    'dictionary' => $dictionary
                ]
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $error->getMessage(),
                    'default' => true
                ]
            );
        }
    }
}
