package com.example.amicacina;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.squareup.picasso.Picasso;

import org.w3c.dom.Text;

import java.util.Objects;

public class activity_details extends AppCompatActivity{

    ImageView imgFoto;
    TextView txtCidade, txtNome, txtRaca, txtNascimento, txtIdade, txtStatus, txtGenero, txtPorte, txtComportamento;
    String fav_action;
    Cursor cursor;

    @SuppressLint("Range")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        // Esconde a barra superior para fins estéticos
        ActionBar actionBar = getSupportActionBar();
        actionBar.hide();

        // Instanciamento dos elementos responsáveis por receber os dados
        imgFoto = (ImageView) findViewById(R.id.imgFoto);
        txtNome = (TextView) findViewById(R.id.txtNome);
        txtRaca = (TextView) findViewById(R.id.txtRaca);
        txtNascimento = (TextView) findViewById(R.id.txtNascimento);
        txtIdade = (TextView) findViewById(R.id.txtIdade);
        txtStatus = (TextView) findViewById(R.id.txtStatus);
        txtGenero = (TextView) findViewById(R.id.txtGenero);
        txtPorte = (TextView) findViewById(R.id.txtPorte);
        txtComportamento= (TextView) findViewById(R.id.txtComportamento);
        txtCidade = (TextView) findViewById(R.id.txtCidade);

        DatabaseController db = new DatabaseController(activity_details.this);

        if(MainActivity.from_fav){
            cursor = db.retrieveFavPets();
            for(int i=0; i < MainActivity.pos; i++){
                cursor.moveToNext();
            }
        }else {
            cursor = db.retrieveData();
            for (int i = 0; i < MainActivity.pos; i++) {
                cursor.moveToNext();
            }
        }

        MainActivity.id_pet = cursor.getInt(cursor.getColumnIndex("id"));
        Picasso.get().load(cursor.getString(cursor.getColumnIndex("foto"))).into(imgFoto);
        txtNome.setText(cursor.getString(cursor.getColumnIndex("nome")));
        txtRaca.setText(cursor.getString(cursor.getColumnIndex("raca")));
        txtNascimento.setText(cursor.getString(cursor.getColumnIndex("nascimento")));
        txtIdade.setText(cursor.getString(cursor.getColumnIndex("idade")));

        String status = cursor.getString(cursor.getColumnIndex("status"));
        if(Objects.equals(status, "em_adocao")){
            txtStatus.setText("em adoção");
        }
        else{
            txtStatus.setText(status);
        }

        Button btnFav = (Button)findViewById(R.id.btnFav);
        String favoritado = cursor.getString(cursor.getColumnIndex("favoritado"));
        if(favoritado.equals("true")){
            btnFav.setText("Desfavoritar");
            fav_action="desfavoritar";
        }else{
            btnFav.setText("Favoritar");
            fav_action="favoritar";
        }

        txtGenero.setText(cursor.getString(cursor.getColumnIndex("genero")));
        txtPorte.setText(cursor.getString(cursor.getColumnIndex("porte")));
        txtComportamento.setText(cursor.getString(cursor.getColumnIndex("comportamento")));


        String endereco_to_split = cursor.getString(cursor.getColumnIndex("endereco"));
        String[] splitted_endereco = endereco_to_split.split("-", 2);
        String cidade = splitted_endereco[1];
        txtCidade.setText(cidade);

        // Método usado para definir um animal como favoritado ou não
        findViewById(R.id.btnFav).setOnClickListener(new View.OnClickListener()
        {
            public void onClick(View v)
            {
                if(fav_action=="favoritar"){
                    Toast.makeText(activity_details.this, "Pet adicionado aos favoritos!", Toast.LENGTH_SHORT).show();
                    db.favPet(cursor.getInt(cursor.getColumnIndex("id")), "true");
                    btnFav.setText("Desfavoritar");
                    fav_action = "desfavoritar";
                }else if(fav_action=="desfavoritar"){
                    Toast.makeText(activity_details.this, "Pet removido dos favoritos!", Toast.LENGTH_SHORT).show();
                    db.favPet(cursor.getInt(cursor.getColumnIndex("id")), "false");
                    btnFav.setText("Favoritar");
                    fav_action = "favoritar";
                }
            }
        });

        // Método para realizar a troca para a tela activity_info
        findViewById(R.id.btnAdotar).setOnClickListener(new View.OnClickListener()
        {
            public void onClick(View v)
            {
                startActivity(new Intent(activity_details.this, activity_info.class));
            }
        });
    }
}