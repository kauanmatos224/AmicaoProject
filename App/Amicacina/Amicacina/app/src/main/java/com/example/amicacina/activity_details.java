package com.example.amicacina;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

public class activity_details extends AppCompatActivity{
    /*String Nome, Raca, Nascimento, Idade, Status, Genero, Porte, Comportamento;
    int Foto;*/
    //int id;
    ImageView imgFoto;
    TextView txtId, txtNome, txtRaca, txtNascimento, txtIdade, txtStatus, txtGenero, txtPorte, txtComportamento;
    Button btnFav, btnAdotar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        //id = GridAdapter.id;

        // Define ActionBar object
        ActionBar actionBar;
        actionBar = getSupportActionBar();

        // Define ColorDrawable object and parse color
        // using parseColor method
        // with color hash code as its parameter
        ColorDrawable colorDrawable
                = new ColorDrawable(Color.parseColor("#e0854e"));

        // Set BackgroundDrawable
        actionBar.setBackgroundDrawable(colorDrawable);

        //txtId  = (TextView) findViewById(R.id.txtId);
        imgFoto = (ImageView) findViewById(R.id.imgFoto);
        txtNome = (TextView) findViewById(R.id.txtNome);
        txtRaca = (TextView) findViewById(R.id.txtRaca);
        txtNascimento = (TextView) findViewById(R.id.txtNascimento);
        txtIdade = (TextView) findViewById(R.id.txtIdade);
        txtStatus = (TextView) findViewById(R.id.txtStatus);
        txtGenero = (TextView) findViewById(R.id.txtGenero);
        txtPorte = (TextView) findViewById(R.id.txtPorte);
        txtComportamento= (TextView) findViewById(R.id.txtComportamento);

        //btnFav = (Button)findViewById(R.id.btnFav);

        imgFoto.setImageResource(MainActivity.foto[MainActivity.pos]);
        txtNome.setText(MainActivity.nome[MainActivity.pos]);
        txtRaca.setText(MainActivity.raca[MainActivity.pos]);
        txtNascimento.setText(MainActivity.nasc[MainActivity.pos]);
        txtIdade.setText(MainActivity.idad[MainActivity.pos]);
        txtStatus.setText(MainActivity.stat[MainActivity.pos]);
        txtGenero.setText(MainActivity.gene[MainActivity.pos]);
        txtPorte.setText(MainActivity.port[MainActivity.pos]);
        txtComportamento.setText(MainActivity.comp[MainActivity.pos]);



        findViewById(R.id.btnFav).setOnClickListener(new View.OnClickListener()
        {
            public void onClick(View v)
            {
                MainActivity.fav[MainActivity.pos] = true;
                /*fragment_fav.favId.add(MainActivity.id[MainActivity.pos]);
                fragment_fav.totalFav = fragment_fav.totalFav++;*/
            }
        });

        findViewById(R.id.btnAdotar).setOnClickListener(new View.OnClickListener()
        {
            public void onClick(View v)
            {
                startActivity(new Intent(activity_details.this, activity_info.class));
            }
        });

        /*
        //txtId.setText(GridAdapter.id);
        txtNome.setText(GridAdapter.nome);
        txtRaca.setText(GridAdapter.raca);
        txtNascimento.setText(GridAdapter.nasc);
        txtIdade.setText(GridAdapter.idad);
        txtStatus.setText(GridAdapter.stat);
        txtGenero.setText(GridAdapter.gene);
        txtPorte.setText(GridAdapter.port);
        txtComportamento.setText(GridAdapter.comp);*/
        /*
        GridModel grid = new GridModel(Nome, Raca, Nascimento, Idade, Status, Genero, Porte, Comportamento, Foto);
        txtNome.setText(grid.getpet_name());
        txtRaca.setText(grid.getPet_raca());
        txtNascimento.setText(grid.getPet_nasc());
        txtIdade.setText(grid.getPet_idad());
        txtStatus.setText(grid.getPet_stat());
        txtGenero.setText(grid.getPet_gene());
        txtPorte.setText(grid.getPet_port());
        txtComportamento.setText(grid.getPet_comp());

         */
/*
        txtNome.setText(GridModel.getpet_name());
        txtRaca.setText(GridModel.getPet_raca());
        txtNascimento.setText(GridModel.getPet_nasc());
        txtIdade.setText(GridModel.getPet_idad());
        txtStatus.setText(GridModel.getPet_stat());
        txtGenero.setText(GridModel.getPet_gene());
        txtPorte.setText(GridModel.getPet_port());
        txtComportamento.setText(GridModel.getPet_comp());
*/
    }
}