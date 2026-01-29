<?php

declare(strict_types=1);

// 1. Autoload (WARSTWA IMPLEMENTACJI)
require dirname(__DIR__) . '/vendor/autoload.php';

use VibeCore\Bootstrap\Bootstrap;
use VibeCore\Http\HttpKernel;
use VibeCore\Routing\{Router, RouteDsl, DispatchHandler};
use VibeCore\Http\{HandlerInterface, Request, RequestContext, Response};
use VibeCore\Schema\{EntityDsl, FieldDsl};

// 2. Minimalny handler testowy
final class PingHandler implements HandlerInterface
{
    public function handle(Request $request, RequestContext $ctx): Response
    {
        $user = EntityDsl::define('user')
            ->description('System users')
            ->fields(
                FieldDsl::string('name')
                    ->required()
                    ->maxLength(120)
                    ->uiText('Imię', 240)
                    ->editable(),

                FieldDsl::string('lastName')
                    ->required()
                    ->maxLength(160)
                    ->uiText('Nazwisko', 260)
                    ->editable(),

                FieldDsl::string('email')
                    ->required()
                    ->maxLength(240)
                    ->uiText('Email', 320)
                    ->editable()
                    // db intent (MVP)
                    ->column('email'),

                FieldDsl::string('password')
                    ->required()
                    ->maxLength(255)
                    ->uiLabel('Hasło')
                    ->form(component: 'password', width: 260)
                    ->editable(),

                FieldDsl::int('age')
                    ->uiLabel('Wiek')
                    ->form(component: 'number', width: 120)
                    ->nullable()
                    ->editable(),

                FieldDsl::bool('isActive')
                    ->uiLabel('Aktywny')
                    ->form(component: 'switch', width: 120)
                    // jeśli masz już w DbMeta default/nullable:
                    // ->dbDefault(true)
                    ->editable()
            )
            // jeśli masz już entity-level behaviour methods:
            ->timestamps()     // createdAt, updatedAt (default names)
            ->softDelete()    // deletedAt (default name)
            // (opcjonalnie później) ->actorSignature()
            ->toSchema();


        return Response::json($user);
    }
}

final class NotFoundHandler implements HandlerInterface
{
    public function handle(Request $request, RequestContext $ctx): Response
    {
        return Response::json(['error' => 'not_found'], 404);
    }
}

// 3. Routing
$router = new Router();
RouteDsl::on($router)->get('/', new PingHandler());
RouteDsl::on($router)->get('/ping', new PingHandler());

$dispatch = new DispatchHandler($router, new NotFoundHandler());

// 4. HttpKernel
$kernel = new HttpKernel(
    middlewares: [],
    handler: $dispatch
);

// 5. Bootstrap runtime
$runtime = Bootstrap::create()
    ->timezone('Europe/Warsaw')
    ->http($kernel)
    ->build();

// 6. Run
$response = $runtime->http()->handleGlobals();
$runtime->http()->emit($response);
