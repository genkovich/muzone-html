<?php
declare(strict_types=1);


namespace Infrastructure\Symfony\Commands;

use Google\Client;
use Google\Service\Sheets;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'crm:sync-individual-leads', description: 'Syncs group leads from Google Sheets to CRM')]
final class SyncSheetsToCRMIndividualLeads extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Syncing leads from Google Sheets to CRM...');

        ini_set('max_execution_time', 0); //0=NOLIMIT
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/../../weberg-39d08063d530.json');
        $client = new Client();
        $client->useApplicationDefaultCredentials();

        $client->addScope('https://www.googleapis.com/auth/spreadsheets');

        $service = new Sheets($client);

        $spreadsheetId = '16PGmc0j6EfrWMJsW2yO_TWQCNlwXkddTZqVf10IEXTw';

        $response = $service->spreadsheets_values->get($spreadsheetId, 'Лиды!A420:L1000');


        $statuses = [
            'Связался с нами' => 172297,
            'Получил инфу' => 172300,
            '2й контакт' => 172301,
            'Записался на пробник' => 172303,
            'Подтвердил что будет' => 172304,
            'Пришел' => 172305,
            'Купил абонемент' => 172308,
            'Отказался после посещения' => 172306,
            'Отказался' => 179693,
            'Перенос пробника' => 172307,
            'Игнор' => 172302,
        ];

        $direction = [
            'Барабаны' => 'Барабани',
            'Вокал' => 'Вокал',
            'Гитара' => 'Гітара',
            'Фортепиано' => 'Фортепіано',
            'Саксофон' => 'Саксофон',
            'Другое' => 'Інше',
            'Свидание (барабаны)' => 'Барабани',
        ];

        $source = [
            'Инста' => 'Instagram',
            'Телега' => 'Telegram',
            'Звонок' => 'Дзвінок',
            'Заявка сайт' => 'Сайт',
            'Другое' => 'Інше',
            'ОЛХ' => 'OLX',
        ];

        $sheetsValues = $response->getValues();

        $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijg4NjYxNDBmYWRlMjMxZDFmMWFlMTE2ZmUwYzYzMjYwYTQ5MzFiMDQzOWE3OTRjZTYxYmZjZjIyZjA1NWRkNTU5YTI1NjU4Y2JmYjAwMWQzIn0.eyJhdWQiOiI2YTA3ZWYyMzY0MWQ1MTMyMGRlZGMwMTMxOTgxMDQ4ZCIsImp0aSI6Ijg4NjYxNDBmYWRlMjMxZDFmMWFlMTE2ZmUwYzYzMjYwYTQ5MzFiMDQzOWE3OTRjZTYxYmZjZjIyZjA1NWRkNTU5YTI1NjU4Y2JmYjAwMWQzIiwiaWF0IjoxNjc3MDU5NTI5LCJuYmYiOjE2NzcwNTk1MjksImV4cCI6MTY3NzA2MzEyOSwic3ViIjoiIiwic2NvcGVzIjpbXSwidXNlciI6eyJpZCI6ODE5NDk3NiwiZ3JvdXBfaWQiOm51bGwsInBhcmVudF9pZCI6bnVsbCwiYXJlYSI6InJlc3QifX0.IG32S6ezFvXTjs6Y63_fvIrEPwYY4e-jX5rOdi6PuGfebg5C57w6SYoUhX5qEQ2ReKYZHeAj08iTmnSn1A8dnuJmwqHbUgnJ1e2p_iHc5l6zkfmLDg_aEw2Bazm4itSRU6oaH2uU7txhP6-Wl2JJK3hjcVmpARmsOnRODpBGCZ6X2sfByjLMQLyc-thHUCtQAEaNHHf-fuHgUrnOKMdWzQspnsWWg3gEuavu_wMJ3sQOj1RUKFahW0Ek45CD_vJHSyWlgXjXNcmsgmhOgR9CcJToH9GSkGGn07o4j7KMCSDhx3h-uhiti0K77u50uOjPAh3tWKvroThZ_COofAjH-Q';

        $curlClient = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.sendpulse.com/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);

        $pipelineId = 51858;

        $output->writeln('Total leads: ' . \count($sheetsValues));

        foreach ($sheetsValues as $value) {
            $contact = [
                'responsibleId' => 8194976,
                'firstName' => $value[3] ?? '-',
                'lastName' => $value[1],
                'phone' => $value[2],

                'messengers' => [
                    [
                        'typeId' => 4, //instgram
                        'login' => \str_replace('@', '', $value[1]),
                    ]
                ],
            ];


            $response = $curlClient->post(
                'crm/v1/contacts',
                [
                    'json' => $contact
                ]
            );
            $responseContact = json_decode($response->getBody()->getContents(), true);

            $contactId = $responseContact['data']['id'];

            $date = empty($value[9]) || $value[9] == '-' ? new \DateTimeImmutable('1970-01-01') : (new \DateTimeImmutable($value[9] . ' ' . $value[10] ));
            $deal = [
                'pipelineId' => $pipelineId,
                'stepId' => $statuses[$value['8']],
                'responsibleId' => 8194976,
                'name' => $value['3'] . ' ' . $value['1'],
                'price' => 0,
                'currency' => 'UAH',
                'sourceId' => null,
                'contact' => [
                    'id' => $contactId,
                ],
                'attributes' => [
                    [
                        'attributeId' => 272838,
                        'value' => $source[$value['4']],
                    ]
                ]


            ];
            $output->writeln('$source: ' . $source[$value['4']]);

            if ($value[6] !== '') {
                $deal['attributes'][] = [
                    'attributeId' => 272835,
                    'value' => $direction[$value['6']],
                ];
                $output->writeln('Direction: ' . $direction[$value['6']]);

                if ($value[6] === 'Свидание (барабаны)') {
                    $deal['attributes'][] = [
                        'attributeId' => 272836,
                        'value' => 'Свидание | 2000',
                    ];
                    $output->writeln('Attribute: ' . 'Svidanie (barabany)');
                }

            }

            if ($value[7] !== '') {
                $deal['attributes'][] = [
                    'attributeId' => 272837,
                    'value' => $value[7],
                ];
                $output->writeln('teatcher: ' . $value['7']);

            }


            $output->writeln('Deal: ' . $value['3'] . ' ' . $value['1']);

            $response = $curlClient->post(
                'crm/v1/deals',
                [
                    'json' => $deal
                ]
            );


            $responseDeal = json_decode($response->getBody()->getContents(), true);
            $output->writeln(json_encode($responseDeal));

            $dealId = $responseDeal['data']['id'];

            $response = $curlClient->post(
                'crm/v1/deals/' . $dealId . '/comments',
                [
                    'json' => [
                        'message' => $value['11'] ?? '-',
                    ]
                ]
            );
            $responseComment = json_decode($response->getBody()->getContents(), true);

            $output->writeln(json_encode($responseComment));

        }


        $output->writeln('Done.');

        return 0;
    }


}