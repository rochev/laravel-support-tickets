<?php

namespace Rochev\Laravel\SupportTickets\Http\Controllers;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Rochev\Laravel\SupportTickets\Entities\Ticket;
use Rochev\Laravel\SupportTickets\Http\Middleware\ForceJsonResponseMiddleware;
use Rochev\Laravel\SupportTickets\Http\Resources\TicketResource;

/**
 * Class TicketController
 */
class TicketController extends Controller
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;
    /**
     * @var ValidationFactory
     */
    private $validationFactory;

    /**
     * TicketController constructor.
     *
     * @param ResponseFactory $responseFactory
     * @param ValidationFactory $validationFactory
     */
    public function __construct(
        ResponseFactory $responseFactory,
        ValidationFactory $validationFactory
    )
    {
        $this->responseFactory = $responseFactory;
        $this->validationFactory = $validationFactory;

        $this->middleware([
            ForceJsonResponseMiddleware::class
        ]);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return TicketResource::collection(Ticket::paginate());
    }

    /**
     * @param Request $request
     *
     * @return TicketResource
     */
    public function store(Request $request)
    {
        $this->validationFactory->make($request->all(), [
            'message' => [
                'required',
                'string',
            ],
        ])->validate();

        $ticket = Ticket::create($request->only(['message']));

        return new TicketResource($ticket);
    }

    /**
     * @param Ticket $ticket
     *
     * @return TicketResource
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * @param Request $request
     * @param Ticket $ticket
     *
     * @return TicketResource
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->validationFactory->make($request->all(), [
            'message' => [
                'required',
                'string',
            ],
        ])->validate();

        $ticket->update($request->only(['message']));

        return new TicketResource($ticket);
    }

    /**
     * @param Ticket $ticket
     *
     * @return JsonResponse
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return $this->responseFactory->json(null, 204);
    }
}
