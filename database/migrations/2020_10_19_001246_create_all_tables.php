<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancos', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('nombre', 50);
        });

        Schema::create('regiones', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('nombre', 50);
            $table->char('abreviatura', 3);
            $table->string('capital', 30);
        });

        Schema::create('provincias', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('nombre', 50);
            $table->smallInteger('idRegion');

            $table->foreign('idRegion')->references('id')->on('regiones')->onDelete('cascade');
        });

        Schema::create('comunas', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('nombre', 50);
            $table->smallInteger('idProvincia');

            $table->foreign('idProvincia')->references('id')->on('provincias')->onDelete('cascade');
        });

        Schema::create('tipos_cuenta_bancaria', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('nombre', 30);
        });

        Schema::create('tipos_inmueble', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('nombre', 30);
        });

        Schema::create('estados_inmueble', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('nombre', 30);
        });

        /*Schema::create('categorias_notificacion', function (Blueprint $table) {
            $table->smallInteger('id')->primary();
            $table->string('nombre', 50);
        });*/

        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('rut', 12)->primary();
            $table->string('primerNombre', 50);
            $table->string('segundoNombre', 50)->nullable();
            $table->string('primerApellido', 50);
            $table->string('segundoApellido', 50)->nullable();
            $table->date('fechaNacimiento');
            $table->string('telefono', 12);
            $table->string('urlFoto');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('antecedentes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 80);
            $table->string('urlDocumento');
            $table->string('rutUsuario', 12);
            $table->timestamps();

            $table->foreign('rutUsuario')->references('rut')->on('usuarios')->onDelete('cascade');
        });

        Schema::create('cuentas_bancarias', function (Blueprint $table) {
            $table->string('rutUsuario', 12)->unique();
            $table->string('numero', 60);
            $table->smallInteger('idBanco');
            $table->smallInteger('idTipo');
            $table->timestamps();

            $table->foreign('rutUsuario')->references('rut')->on('usuarios')->onDelete('cascade');
            $table->foreign('idBanco')->references('id')->on('bancos')->onDelete('cascade');
            $table->foreign('idTipo')->references('id')->on('tipos_cuenta_bancaria')->onDelete('cascade');
        });

        /*Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('rutUsuario', 12);
            $table->smallInteger('idCategoria');
            $table->bigInteger('idReferencia');
            $table->string('mensaje');
            $table->boolean('estado');
            $table->timestamps();

            $table->foreign('rutUsuario')->references('rut')->on('usuarios')->onDelete('cascade');
            $table->foreign('idCategoria')->references('id')->on('categorias_notificacion')->onDelete('cascade');
        });*/

        Schema::create('inmuebles', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('idTipoInmueble');
            $table->smallInteger('idEstado');
            $table->smallInteger('idComuna');
            $table->string('rutPropietario', 12);
            $table->string('poblacionDireccion', 80)->nullable();
            $table->string('calleDireccion', 80);
            $table->smallInteger('numeroDireccion');
            $table->string('condominioDireccion', 80)->nullable();
            $table->string('numeroDepartamentoDireccion', 20)->nullable();
            $table->string('caracteristicas');
            $table->timestamps();

            $table->foreign('idTipoInmueble')->references('id')->on('tipos_inmueble');
            $table->foreign('idEstado')->references('id')->on('estados_inmueble');
            $table->foreign('idComuna')->references('id')->on('comunas');
            $table->foreign('rutPropietario')->references('rut')->on('usuarios')->onDelete('cascade');
        });

        Schema::create('fotos_inmueble', function (Blueprint $table) {
            $table->id();
            $table->string('urlFoto');
            $table->unsignedBigInteger('idInmueble');
            $table->timestamps();

            $table->foreign('idInmueble')->references('id')->on('inmuebles')->onDelete('cascade');
        });

        Schema::create('anuncios', function (Blueprint $table) {
            $table->unsignedBigInteger('idInmueble')->primary();
            $table->string('condicionesArriendo');
            $table->string('documentosRequeridos');
            $table->mediumInteger('canon');
            $table->date('fechaPublicacion');
            $table->boolean('estado');
            $table->timestamps();

            $table->foreign('idInmueble')->references('id')->on('inmuebles')->onDelete('cascade');
        });

        Schema::create('interes_usuario_anuncio', function (Blueprint $table) {
            $table->unsignedBigInteger('idAnuncio');
            $table->string('rutUsuario', 12);
            $table->boolean('candidato');
            $table->timestamps();

            $table->foreign('idAnuncio')->references('idInmueble')->on('anuncios')->onDelete('cascade');
            $table->foreign('rutUsuario')->references('rut')->on('usuarios')->onDelete('cascade');
            $table->primary(['idAnuncio', 'rutUsuario']);
        });

        Schema::create('arriendos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idInmueble');
            $table->date('fechaInicio');
            $table->date('fechaTerminoPropuesta');
            $table->date('fechaTerminoReal');
            $table->mediumInteger('canon');
            $table->string('rutInquilino', 12);
            $table->smallInteger('diaPago');
            $table->boolean('estado');
            $table->boolean('renovar');
            $table->string('urlContrato')->nullable();
            $table->smallInteger('numeroRenovacion');
            $table->timestamps();

            $table->foreign('idInmueble')->references('id')->on('inmuebles')->onDelete('cascade');
            $table->foreign('rutInquilino')->references('rut')->on('usuarios')->onDelete('cascade');
        });

        Schema::create('garantias', function (Blueprint $table) {
            $table->unsignedBigInteger('idArriendo')->primary();
            $table->boolean('estado');
            $table->mediumInteger('monto');
            $table->smallInteger('diasRetraso');

            $table->foreign('idArriendo')->references('id')->on('arriendos')->onDelete('cascade');
        });

        Schema::create('pagos_garantia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idGarantia');
            $table->date('fecha');
            $table->string('urlComprobante');
            $table->timestamps();

            $table->foreign('idGarantia')->references('idArriendo')->on('garantias')->onDelete('cascade');
        });

        Schema::create('devoluciones_garantia', function (Blueprint $table) {
            $table->unsignedBigInteger('idGarantia')->primary();
            $table->mediumInteger('monto');
            $table->date('fecha');
            $table->string('urlComprobante');
            $table->timestamps();

            $table->foreign('idGarantia')->references('idArriendo')->on('garantias')->onDelete('cascade');
        });

        Schema::create('descuentos_devolucion_garantia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idDevolucionGarantia');
            $table->mediumInteger('monto');
            $table->string('motivo');
            $table->timestamps();

            $table->foreign('idDevolucionGarantia')->references('idGarantia')->on('devoluciones_garantia')->onDelete('cascade');
        });

        Schema::create('deudas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idArriendo');
            $table->string('titulo', 50);
            $table->date('fechaCompromiso');
            $table->boolean('estado');
            $table->smallInteger('diasRetraso');
            $table->timestamps();

            $table->foreign('idArriendo')->references('id')->on('arriendos')->onDelete('cascade');
        });

        Schema::create('pagos_deuda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idDeuda');
            $table->date('fecha');
            $table->string('urlComprobante');
            $table->timestamps();

            $table->foreign('idDeuda')->references('id')->on('deudas')->onDelete('cascade');
        });

        Schema::create('solicitudes_finalizacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idArriendo');
            $table->string('rutEmisor', 12);
            $table->string('rutReceptor', 12);
            $table->date('fechaPropuesta');
            $table->boolean('respuesta')->nullable();
            $table->boolean('estado');
            $table->timestamps();

            $table->foreign('idArriendo')->references('id')->on('arriendos')->onDelete('cascade');
            $table->foreign('rutEmisor')->references('rut')->on('usuarios')->onDelete('cascade');
            $table->foreign('rutReceptor')->references('rut')->on('usuarios')->onDelete('cascade');
        });

        Schema::create('calificaciones', function (Blueprint $table) {
            $table->unsignedBigInteger('idArriendo')->primary();
            $table->smallInteger('cumplimientoInquilino');
            $table->smallInteger('notaAlArriendo')->nullable();
            $table->smallInteger('notaAlInquilino')->nullable();
            $table->string('comentarioAlArriendo')->nullable();
            $table->string('comentarioAlInquilino')->nullable();
            $table->timestamps();

            $table->foreign('idArriendo')->references('id')->on('arriendos')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones');
        Schema::dropIfExists('solicitudes_finalizacion');
        Schema::dropIfExists('pagos_deuda');
        Schema::dropIfExists('deudas');
        Schema::dropIfExists('arriendos');
        Schema::dropIfExists('descuentos_devolucion_garantia');
        Schema::dropIfExists('devoluciones_garantia');
        Schema::dropIfExists('pagos_garantia');
        Schema::dropIfExists('garantias');
        Schema::dropIfExists('interes_usuario_anuncio');
        Schema::dropIfExists('anuncios');
        Schema::dropIfExists('fotos_inmueble');
        Schema::dropIfExists('inmuebles');
        //Schema::dropIfExists('notificaciones');
        Schema::dropIfExists('cuentas_bancarias');
        Schema::dropIfExists('antecedentes');
        Schema::dropIfExists('usuarios');
        //Schema::dropIfExists('categorias_notificacion');
        Schema::dropIfExists('estados_inmueble');
        Schema::dropIfExists('tipos_inmueble');
        Schema::dropIfExists('tipos_cuenta_bancaria');
        Schema::dropIfExists('comunas');
        Schema::dropIfExists('provincias');
        Schema::dropIfExists('regiones');
        Schema::dropIfExists('bancos');
    }
}
