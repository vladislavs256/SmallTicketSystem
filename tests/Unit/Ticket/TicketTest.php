<?php
declare(strict_types=1);

namespace tests\Unit\Ticket;

use App\Models\Tickets\Ticket;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use DatabaseTransactions;
    public function testNew():void
    {
        $ticket = Ticket::new(
            $user_id = 1,
            $subject = "Top",
            $content = "Lorem ipsum",
            $type = 1,
        );

        self::assertNotEmpty($ticket);

        self::assertEquals($subject, $ticket->subject);
        self::assertEquals($content, $ticket->content);

        self::assertTrue($ticket->isOpen());
        self::assertFalse($ticket->isClose());
    }
}
