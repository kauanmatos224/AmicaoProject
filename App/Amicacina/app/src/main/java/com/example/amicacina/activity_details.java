package com.example.amicacina;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.TextView;

public class activity_details extends AppCompatActivity{
    /*String Nome, Raca, Nascimento, Idade, Status, Genero, Porte, Comportamento;
    int Foto;*/
    ImageView imgFoto;
    TextView txtNome, txtRaca, txtNascimento, txtIdade, txtStatus, txtGenero, txtPorte, txtComportamento;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        imgFoto = (ImageView) findViewById(R.id.imgFoto);
        txtNome = (TextView) findViewById(R.id.txtNome);
        txtRaca = (TextView) findViewById(R.id.txtRaca);
        txtNascimento = (TextView) findViewById(R.id.txtNascimento);
        txtIdade = (TextView) findViewById(R.id.txtIdade);
        txtStatus = (TextView) findViewById(R.id.txtStatus);
        txtGenero = (TextView) findViewById(R.id.txtGenero);
        txtPorte = (TextView) findViewById(R.id.txtPorte);
        txtComportamento = (TextView) findViewById(R.id.txtComportamento);

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