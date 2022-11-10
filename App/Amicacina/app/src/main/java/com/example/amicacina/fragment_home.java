package com.example.amicacina;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.Toast;

import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;

import java.util.ArrayList;

public class fragment_home extends Fragment {

    GridView gridviewHome;

    public fragment_home() {
        // Required empty public constructor
    }


    @SuppressLint("Range")
    @Override

    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);

        // Instanciando o gridview com o elemento gráfico
        gridviewHome = (GridView) view.findViewById(R.id.GridViewHome);

        // Criação de uma lista de arrays, utilizando como modelo a classe GridModel, onde foi
        // determinada as variáveis necessárias e suas devidas posições
        ArrayList<GridModel> gridModelArrayList = new ArrayList<GridModel>();


        DatabaseController db = new DatabaseController(getContext());
        Cursor cursor = db.retrieveData();

        for(int i=0 ; i < cursor.getCount(); i++){
            gridModelArrayList.add(new GridModel(

                    cursor.getString(cursor.getColumnIndex("id")),
                    cursor.getString(cursor.getColumnIndex("nome")),
                    cursor.getString(cursor.getColumnIndex("raca")),
                    cursor.getString(cursor.getColumnIndex("nascimento")),
                    cursor.getString(cursor.getColumnIndex("idade")),
                    cursor.getString(cursor.getColumnIndex("status")),
                    cursor.getString(cursor.getColumnIndex("genero")),
                    cursor.getString(cursor.getColumnIndex("porte")),
                    cursor.getString(cursor.getColumnIndex("comportamento")),
                    cursor.getString(cursor.getColumnIndex("foto"))
            ));

            cursor.moveToNext();

        }

        // Método do adaptador, responsável por pegar os dados com sua estrutura definida no GridModel
        // e usando o adaptador do GridAdapter para preencher os dados na gridview
        GridAdapter adapter = new GridAdapter(getContext(), gridModelArrayList);
        gridviewHome.setAdapter(adapter);

        // Método para definir uma ação ao clicar em um item do gridview
        gridviewHome.setOnItemClickListener(new GridView.OnItemClickListener(){
            @Override
            public void onItemClick(AdapterView parent, View view, int position, long id) {

                // Ao clicar em um item, ele pega a posição dele no adaptador e guarda em uma variável
                // em seguida ele muda para a activity_details
                MainActivity.pos = position;
                Intent intent = new Intent();
                intent.setClass(getActivity(), activity_details.class);
                getActivity().startActivity(intent);

            }

        });
        // Inflate the layout for this fragment
        return view;
    }
}