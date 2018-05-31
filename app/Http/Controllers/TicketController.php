<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Ticket;
class TicketController extends Controller
{
    public function get_tickets()
    {
        return response()->json(Ticket::lista_tickets());
    }
    public function get_detalles_tickets($id)
    {
        return response()->json(Ticket::detalles_tickets($id));
    }
}
