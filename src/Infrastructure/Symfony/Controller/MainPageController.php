<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Controller;

use Domain\Age;
use Domain\Direction;
use Domain\GroupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/', name: 'main_page')]
final class MainPageController extends AbstractController
{
    public function __invoke(Request $request, TranslatorInterface $translator): Response
    {
        $request->setLocale($request->get('_locale'));

        $services = [
            1 => [
                'img' => 'build/images/1.jpg',
                'img2x' => 'build/images/1@2x.jpg',
                'title' => '🥁 Барабани 🥁',
                'direction' => Direction::Drums->value,
                'desc' => '<h3> Просто та завжди драйвово  </h3>
                <p>З давніх часів, барабани виконували неймовірну кількість соціальних функцій: починаючи від передачі важливої інформації, залякування ворогів, допомогали на полюванні, і закінчуючи магічними ритуалами та терапевтичними процедурами. Наразі барабани це про музику, радість, щастя, а з нами ще і про легкість. </p>
                <p>🎵 З нами ви зможете: </p>
                <ol>
                    <li>🎓 Навчитися грати та вивчити улюблені пісні </li>
                    <li>💥 Зняти стрес. Адже де ще можна галасувати та "барабанити" на повну </li>
                    <li>⚡ "Вдарити" по старим нейронним зв\'язкам та розвивати інтелект. </>
                    <li>✨ "Прибити" рухові розлади та покращити координацію. </li>
                    <li>🧠 Розвивати пам\'ять </li>
                </ol>
                <p>Так що, якщо хочете "барабанити" у житті з новим ритмом, приєднуйтесь до нас! </p>

                ',
            ],
            2 => [
                'img' => 'build/images/2.jpg',
                'img2x' => 'build/images/2@2x.jpg',
                'title' => '🎤 Вокал 🎤',
                'direction' => Direction::Vocal->value,
                'desc' => '<h3>Крутезний інструмент для покращення дикції, дихання, подолання страху комунікації та сцени</h3>

                <p>💬 Вокал - це мозкова йога та антидепресант для тіла, що вирішує як соціальні, так і фізичні проблеми</p>
                <p>🎶 Заняття допоможуть:</p>
                <ol>
                    <li>🔍 Навчитись співати та володіти голосом</li>
                    <li>🎭 Подолати страх сцени</li>
                    <li>🧘‍♀️ Зняти стрес. Бо хто казав, що співати менше кайфово, ніж медитувати?</li>
                    <li>🧩 Будівництві нових нейронних мостів та розвитку інтелекту</li>
                    <li>🗣️ Налагодженні комунікації</li>
                </ol>
                <p>Отож, якщо хочете насолодитися життям на повну і стати вокальною зіркою, забігайте до нас! 🌟</p>',
            ],
            3 => [
                'img' => 'build/images/3.jpg',
                'img2x' => 'build/images/3@2x.jpg',
                'title' => '🎹 Клавішні 🎹',
                'direction' => Direction::Piano->value,
                'desc' => '
                <h3> інструмент для емоційного та креативного самовираження </h3>

                    <p>🔥 Фортепіано - клавішний інструмент, на якому можна не тільки відтворювати популярні пісні, а й імпровізувати та створювати свої власні хіти. Хто знає, може, настане час, і твій шедевр стане гімном наступного покоління! 😉</p>
                    <p>🚀 Крім того, гра на фортепіано допоможе вам розвинути:</p>
                    <ol>
                        <li>🥁 Відчуття ритму</li>
                        <li>🎯 Концентрацію, щоб не втратити ні одного акорду</li>
                        <li>🎤 Інтонаційні вокальні навички</li>
                        <li>📝 Майстерність у створенні власних пісень</li>
                        <li>📚 Покращення знань з теорії музики та сольфеджіо </li>
                        <li>🎉 Отримання необхідних навичок та насолоди від гри, бо може це стане твоїм секретним способом розслаблення?</li>
                    </ol>
                    <p>З фортепіано твоє життя набуде яскравих кольорів, неповторних мелодій та незабутніх пригод! 🎉 Ми чекаємо на тебе</p>
                ',
            ],
            4 => [
                'img' => 'build/images/4.jpg',
                'img2x' => 'build/images/4@2x.jpg',
                'title' => '🎸 Гітара 🎸 ',
                'direction' => Direction::Guitar->value,
                'desc' => '
                    <h3>Крутий інструмент, який добре звучить як в групі так і сольно </h3>

                   <p> Вона допоможе грати улюблені треки, та просто зробить тебе зіркою на будь-якій вечірці. З гітарою ти зможеш: </p>
        <ol>
            <li>😎 Навчитись грати на неймовірно популярному інструменті, покращуючи пам\'ять, концентрацію та музичний слух</li>
            <li>🎶 Створювати мелодії, поєднуючи ритм та гармонію</li>
            <li>🤲 Розвивати дрібну моторику і стати спритним, немов ніндзя</li>
            <li>💡 Розвивати творче мислення та створювати нові музичні шедеври</li>
            <li>🌟 Вивчити різні техніки та прийоми, адже гітара - універсальний інструмент, який використовується в усіх стилях музики</li>
        </ol>
         <p>🔥 Так що, якщо хочеш стати гітарним супергероєм та підкорити світ своїми мелодіями, приєднуйся до нас та почни свій шлях до слави! 🚀 </p>
                ',
            ],
            5 => [
                'img' => 'build/images/5.jpg',
                'img2x' => 'build/images/5@2x.jpg',
                'title' => '🏝️ Укулеле 🏝️',
                'direction' => Direction::Ukulele->value,
                'desc' => '
                <p> інструмент, який додасть трішки гавайського сонця в твоє життя ️☀️</p>
                    <p>З укулеле ти зможеш:</p>
                    <ul>
                      <li>😎 Відчути гавайський дух, граючи на цьому маленькому інструменті, що розвиває пам\'ять та музичний слух.</li>
                      <li>🎵 Створювати прості, але захоплюючі мелодії, які зарядять тебе позитивною енергією.</li>
                      <li>💡 Розвивати творче мислення та імпровізувати власні композиції, навіть якщо ти новачок.</li>
                      <li>🌟 Вивчити основи гри на струнних інструментах, стаючи універсальним музикантом.</li>
                    </ul>
                <p>🚀 То ж приєднуйся до нас, щоб зануритись в океан тропічних мелодій та підкорити світ своїми музичними вібраціями 🌊</p>
                ',
            ],
            6 => [
                'img' => 'build/images/6.jpg',
                'img2x' => 'build/images/6@2x.jpg',
                'title' => '🎷 Саксофон 🎷',
                'direction' => Direction::Saxophone->value,
                'desc' => '
                <h3>інструмент, що додає глибину та експресію твоїй музичній майстерності! 🎶</h3>
                <p>Заціни, чого ти можеш навчитись:</p>
                <ul>
                  <li>🌟 Освоєння артикуляції та фразування, що допоможе виразити емоції через музику</li>
                  <li>🎵 Навчитися грати мелодії з різних музичних стилів</li>
                  <li>🌬️ Розвиток контролю над диханням та підтримки звуку, що поліпшить твою гру на будь-якому духовому інструменті (чи у вокалі)</li>
                  <li>🔀 Вивчити техніки виконання, які підвищать твою музичну гнучкість та дозволять адаптуватися до різних ситуацій на сцені</li>
                  <li>🧠 Розвивати когнітивні здібності, такі як пам\'ять, концентрацію та координацію, граючи складні музичні партії</li>
                </ul>
                <p>🎉 Не пропусти свій шанс відкрити чарівний світ саксофону - приєднуйся до нас та розвивай свої музичні таланти на новому рівні! 🚀</p>
                ', ],
        ];

        $menu = $this->createMenu($translator);

        $tabs = [
            Direction::Drums->value => 'Барабани',
            Direction::Vocal->value => 'Вокал',
            Direction::Piano->value => 'Клавішні',
            Direction::Guitar->value => 'Гітара',
            Direction::Ukulele->value => 'Укулеле',
            Direction::Saxophone->value => 'Саксофон',
        ];

        $cart = [
            0 => [
                'promo' => '20% OFF',
                'price' => '2 200',
                'promo_price' => '1 800',
                'info' => [
                    '4 заняття (1 раз на тиждень)',
                    'індивідуальний підхід',
                    'тривалість одного заняття 55 хв',
                ],
                'type' => 'Індивідуальні',
                'count' => 4,
                'group_type' => GroupType::Individual->value,
                'age' => Age::Adult->value,
            ],
            1 => [
                'promo' => '20% OFF',
                'price' => '3 900',
                'promo_price' => '3 200',
                'count' => 8,
                'info' => [
                    '8 занять (2 рази на тиждень)',
                    'індивідуальний підхід',
                    'тривалість одного заняття 55 хв',
                ],
                'type' => 'Індивідуальні',
                'group_type' => GroupType::Individual->value,
                'age' => Age::Adult->value,
            ],
            2 => [
                'price' => '1 450',
                'count' => 4,
                'info' => [
                    '4 заняття (1 раз на тиждень)',
                    'повний драйв',
                    'злагоджена робота в команді',
                    'тривалість одного заняття 55 хв',
                ],
                'type' => 'Групові',
                'group_type' => GroupType::Group->value,
                'age' => Age::Adult->value,
            ],
            3 => [
                'promo' => '20% OFF',
                'price' => '1 500',
                'promo_price' => '1 250',
                'count' => 4,
                'info' => [
                    '4 заняття (1 раз на тиждень)',
                    'індивідуальний підхід',
                    'тривалість одного заняття 35 хв',
                ],
                'type' => 'Індивідуальні',
                'group_type' => GroupType::Individual->value,
                'age' => Age::Kids->value,
            ],
            4 => [
                'promo' => '20% OFF',
                'price' => '2 850',
                'promo_price' => '2 350',
                'count' => 8,
                'info' => [
                    '8 занять (2 рази на тиждень)',
                    'індивідуальний підхід',
                    'тривалість одного заняття 35 хв',
                ],
                'type' => 'Індивідуальні',
                'group_type' => GroupType::Individual->value,
                'age' => Age::Kids->value,
            ],
            5 => [
                'price' => '1 100',
                'count' => 4,
                'info' => [
                    '4 заняття (1 раз на тиждень)',
                    'соціальна активність',
                    'злагоджена робота в команді',
                    'тривалість одного заняття 35 хв',
                ],
                'type' => 'Групові',
                'group_type' => GroupType::Group->value,
                'age' => Age::Kids->value,
            ],
        ];

        $certificates = [
            1 => [
                'img' => 'build/images/6.jpg',
                'img2x' => 'build/images/6@2x.jpg',
            ],
            2 => [
                'img' => 'build/images/7.jpg',
                'img2x' => 'build/images/7@2x.jpg',
            ],
            3 => [
                'img' => 'build/images/3.jpg',
                'img2x' => 'build/images/3@2x.jpg',
            ],
            4 => [
                'img' => 'build/images/4.jpg',
                'img2x' => 'build/images/4@2x.jpg',
            ],
            5 => [
                'img' => 'build/images/5.jpg',
                'img2x' => 'build/images/5@2x.jpg',
            ],
            6 => [
                'img' => 'build/images/2.jpg',
                'img2x' => 'build/images/2@2x.jpg',
            ],
        ];

        $reviews = [
            [
                'nickname' => 'Тетяна',
                'img' => 'build/images/feedback_1.png',
                'source' => 'instagram',
            ],
            [
                'nickname' => '@dhusvggsh_h',
                'img' => 'build/images/feedback_2.png',
                'source' => 'instagram',
            ],
            [
                'nickname' => '@anonymous',
                'img' => 'build/images/feedback_3.png',
                'source' => 'instagram',
            ],
            [
                'nickname' => 'Olesia Ihoshuna',
                'img' => 'build/images/feedback_4.png',
                'source' => 'instagram',
            ],
            [
                'nickname' => '@anonymous',
                'img' => 'build/images/feedback_5.png',
                'source' => 'instagram',
            ],
        ];

        return $this->render('main/index.html.twig', [
            'menu' => $menu,
            'services' => $services,
            'tabs' => $tabs,
            'cart' => $cart,
            'certificates' => $certificates,
            'reviews' => $reviews,
        ]);
    }

    public function createMenu(TranslatorInterface $translator): array
    {
        return [
            [
                'url' => '#banner',
                'title' => $translator->trans('menu.main'),
            ],
            [
                'url' => '#services',
                'title' => $translator->trans('menu.services'),
                'subitems' => [
                    [
                        'url' => '#drums',
                        'title' => $translator->trans('menu.drums'),
                    ],
                    [
                        'url' => '#vocal',
                        'title' => $translator->trans('menu.vocal'),
                    ],
                    [
                        'url' => '#piano',
                        'title' => $translator->trans('menu.piano'),
                    ],
                    [
                        'url' => '#guitar',
                        'title' => $translator->trans('menu.guitar'),
                    ],
                    [
                        'url' => '#ukulele',
                        'title' => $translator->trans('menu.ukulele'),
                    ],
                    [
                        'url' => '#saxophone',
                        'title' => $translator->trans('menu.saxophone'),
                    ],
                ],
            ],
            [
                'url' => '#cost',
                'title' => $translator->trans('menu.cost'),
            ],
            [
                'url' => '#gift',
                'title' => $translator->trans('menu.gift'),
            ],
            [
                'url' => '#reviews',
                'title' => $translator->trans('menu.reviews'),
            ],
            [
                'url' => '#contacts',
                'title' => $translator->trans('menu.contacts'),
            ],
        ];
    }


}
