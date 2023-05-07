<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Commands;

use Google\Client;
use Google\Service\Sheets;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'crm:sync-group-leads', description: 'Syncs group leads from Google Sheets to CRM')]
final class SyncSheetsToCRMGroupLeads extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Syncing group leads from Google Sheets to CRM...');

        \ini_set('max_execution_time', 0); // 0=NOLIMIT
        \putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/../../weberg-39d08063d530.json');

        $client = new Client();
        $client->useApplicationDefaultCredentials();

        $client->addScope('https://www.googleapis.com/auth/spreadsheets');

        $service = new Sheets($client);

        $spreadsheetId = '16PGmc0j6EfrWMJsW2yO_TWQCNlwXkddTZqVf10IEXTw';

        $response = $service->spreadsheets_values->get($spreadsheetId, 'Групповые!A2:L1000');

        $statuses = [
            'Написал в инст' => 168218,
            'Получил инфу' => 168337,
            '2й контакт' => 168338,
            'Записался на пробник' => 168339,
            'Подтвердил что будет' => 168340,
            'Пришел' => 168341,
            'Купил абонемент' => 168342,
            'Отказался после пробника' => 168343,
            'Отказался' => 168347,
            'Перенос' => 168344,
            'Ожидает группу после пробника' => 168345,
            'Ожидание группы' => 168346,
            'Игнор' => 168225,
        ];

        $direction = [
            'Барабаны' => 'Барабани',
            'Вокал' => 'Вокал',
            'Гитара' => 'Гітара',
        ];

        $sheetsValues = $response->getValues();

        $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI5ZDIyNzc1MzJmMDE4OTgyMDdjMWI4MmEzN2YwODhlN2IxOWY1ZmU1MTViNDAwMTJmOGQ0MzhlMWNmOWEwODg4YWUzN2JhMDVjMmQ4ZGFjIn0.eyJhdWQiOiI2YTA3ZWYyMzY0MWQ1MTMyMGRlZGMwMTMxOTgxMDQ4ZCIsImp0aSI6IjI5ZDIyNzc1MzJmMDE4OTgyMDdjMWI4MmEzN2YwODhlN2IxOWY1ZmU1MTViNDAwMTJmOGQ0MzhlMWNmOWEwODg4YWUzN2JhMDVjMmQ4ZGFjIiwiaWF0IjoxNjc3MDU1MzUzLCJuYmYiOjE2NzcwNTUzNTMsImV4cCI6MTY3NzA1ODk1Mywic3ViIjoiIiwic2NvcGVzIjpbXSwidXNlciI6eyJpZCI6ODE5NDk3NiwiZ3JvdXBfaWQiOm51bGwsInBhcmVudF9pZCI6bnVsbCwiYXJlYSI6InJlc3QifX0.hJ8KXV7nMv1M-dye49G3VEm3mGRvjb8tmlDtc5e_EvTIOQCc85bCXdlLPP2-rtrOlWRqw-owDVTQjwAtkMQI0RbnIsI6zoRX3f2WFSgkrmpdTIQKhQt9fTOe8QEt04POhxRdFdhGlO2nWXp_kTxCh7OJ2OiCjq5DFx8mNMmFSTRWsLXYB62T_GIarhuiQvAIzG2vrpnZK3cq0E_uklhMCdkQs5jrrAZU6GBfNmgCbrzSolptw_FKYAqiR-uiyLskoyr-hfilHTkJJVFASsSc6ZGU5Ckv3dNw2JOosnANTQ9EyeF8yqlMENNf6AsAjDBO0QhQfi2aIixOrplvdgpg7Q';

        $curlClient = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.sendpulse.com/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);

        $pipelineId = 50685;

        $output->writeln('Total leads: ' . \count($sheetsValues));

        foreach ($sheetsValues as $value) {
            $contact = [
                'responsibleId' => 8194976,
                'firstName' => $value[2] ?? '-',
                'lastName' => $value[1],
                'phone' => $value[3],

                'messengers' => [
                    [
                        'typeId' => 4, // instgram
                        'login' => \str_replace('@', '', $value[1]),
                    ],
                ],
            ];

            $response = $curlClient->post(
                'crm/v1/contacts',
                [
                    'json' => $contact,
                ]
            );
            $responseContact = \json_decode($response->getBody()->getContents(), true);

            $contactId = $responseContact['data']['id'];

            $date = empty($value[9]) || '-' === $value[9] ? new \DateTimeImmutable('1970-01-01') : (new \DateTimeImmutable($value[9] . ' ' . $value[10]));
            $deal = [
                'pipelineId' => $pipelineId,
                'stepId' => $statuses[$value['8']],
                'responsibleId' => 8194976,
                'name' => $value['2'] . ' ' . $value['1'],
                'price' => 'Детская' === $value['6'] ? 1100 : 1400,
                'currency' => 'UAH',
                'sourceId' => null,
                'contact' => [
                    'id' => $contactId,
                ],
                'attributes' => [
                    [
                        'attributeId' => 255902,
                        'value' => 'Детская' === $value['6'] ? 'Діти | 4 заняття | 1100 грн.' : 'Дорослі | 4 заняття | 1400 грн.',
                    ],
                    [
                        'attributeId' => 256076,
                        'value' => $direction[$value['4']],
                    ],
                    [
                        'attributeId' => 256082,
                        'value' => 'Детская' === $value['6'] ? 'Дитяча' : 'Доросла',
                    ],
                    //                    [
                    //                        'attributeId' => 256083,
                    //                        'value' => $date,
                    //                    ],
                ],
            ];

            if ('' !== $value[5]) {
                $deal['attributes'][] = [
                    'attributeId' => 256084,
                    'value' => $value[5],
                ];
            }
            $output->writeln('Deal: ' . $value['2'] . ' ' . $value['1']);

            $response = $curlClient->post(
                'crm/v1/deals',
                [
                    'json' => $deal,
                ]
            );

            $responseDeal = \json_decode($response->getBody()->getContents(), true);
            $output->writeln(\json_encode($responseDeal));

            $dealId = $responseDeal['data']['id'];

            $response = $curlClient->post(
                'crm/v1/deals/' . $dealId . '/comments',
                [
                    'json' => [
                        'message' => $value['11'] ?? '-',
                    ],
                ]
            );
            $responseComment = \json_decode($response->getBody()->getContents(), true);

            $output->writeln(\json_encode($responseComment));
        }

        $output->writeln('Done.');

        return 0;
    }
}
