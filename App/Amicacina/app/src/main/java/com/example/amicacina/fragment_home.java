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

        gridviewHome = (GridView) view.findViewById(R.id.GridViewHome);
        //gridviewHome = findViewById(R.id.GridViewHome);

        ArrayList<GridModel> gridModelArrayList = new ArrayList<GridModel>();


        //MainActivity.foto[6] = String.valueOf(R.drawable.pinscher);

        DatabaseController db = new DatabaseController(getContext());
        Cursor cursor = db.retrieveData();

        for(int i=0 ; i < cursor.getCount(); i++){
            gridModelArrayList.add(new GridModel(/*MainActivity.id[i], MainActivity.nome[i], MainActivity.raca[i],
                    MainActivity.nasc[i], MainActivity.idad[i], MainActivity.stat[i],
                    MainActivity.gene[i], MainActivity.port[i], MainActivity.comp[i], MainActivity.foto[i]*/

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

        /*
        gridModelArrayList.add(new GridModel(0, MainActivity.nome[0], MainActivity.raca[0],
                MainActivity.nasc[0], MainActivity.idad[0], MainActivity.stat[0],
                MainActivity.gene[0], MainActivity.port[0], MainActivity.comp[0], MainActivity.foto[0]));

        gridModelArrayList.add(new GridModel(1, MainActivity.nome[1], MainActivity.raca[1],
                MainActivity.nasc[1], MainActivity.idad[1], MainActivity.stat[1],
                MainActivity.gene[1], MainActivity.port[1], MainActivity.comp[1], MainActivity.foto[1]));

        gridModelArrayList.add(new GridModel(2, MainActivity.nome[2], MainActivity.raca[2],
                MainActivity.nasc[2], MainActivity.idad[2], MainActivity.stat[2],
                MainActivity.gene[2], MainActivity.port[2], MainActivity.comp[2], MainActivity.foto[2]));

        gridModelArrayList.add(new GridModel(3, MainActivity.nome[3], MainActivity.raca[3],
                MainActivity.nasc[3], MainActivity.idad[3], MainActivity.stat[3],
                MainActivity.gene[3], MainActivity.port[3], MainActivity.comp[3], MainActivity.foto[3]));

        gridModelArrayList.add(new GridModel(4, MainActivity.nome[4], MainActivity.raca[4],
                MainActivity.nasc[4], MainActivity.idad[4], MainActivity.stat[4],
                MainActivity.gene[4], MainActivity.port[4], MainActivity.comp[4], MainActivity.foto[4]));

        gridModelArrayList.add(new GridModel(5, MainActivity.nome[5], MainActivity.raca[5],
                MainActivity.nasc[5], MainActivity.idad[5], MainActivity.stat[5],
                MainActivity.gene[5], MainActivity.port[5], MainActivity.comp[5], MainActivity.foto[5]));

        gridModelArrayList.add(new GridModel(6, MainActivity.nome[6], MainActivity.raca[6],
                MainActivity.nasc[6], MainActivity.idad[6], MainActivity.stat[6],
                MainActivity.gene[6], MainActivity.port[6], MainActivity.comp[6], MainActivity.foto[6]));
*/
        /*
        gridModelArrayList.add(new GridModel(1, "THOR", "Golden Retriever",
        "21/03/2020", "2 anos", "Aguardando adoção",
        "Macho", "Grande", "Dócil e brincalhão", R.drawable.placeholder));

        gridModelArrayList.add(new GridModel(2, "NINA", "Golden Retriever",
                "21/03/2020", "3 anos", "Aguardando adoção",
                "Macho", "Grande", "Dócil e brincalhão", R.drawable.placeholder));

        gridModelArrayList.add(new GridModel(3, "MAX", "Golden Retriever",
                "21/03/2020", "4 anos", "Aguardando adoção",
                "Macho", "Grande", "Dócil e brincalhão", R.drawable.placeholder));

        gridModelArrayList.add(new GridModel(4, "FUSQUINHA", "Golden Retriever",
                "21/03/2020", "5 anos", "Aguardando adoção",
                "Macho", "Grande", "Dócil e brincalhão", R.drawable.placeholder));

        gridModelArrayList.add(new GridModel(5, "PIPOCA", "Golden Retriever",
                "21/03/2020", "6 anos", "Aguardando adoção",
                "Macho", "Grande", "Dócil e brincalhão", R.drawable.placeholder));

        gridModelArrayList.add(new GridModel(6, "LUNA", "Golden Retriever",
                "21/03/2020", "7 anos", "Aguardando adoção",
                "Macho", "Grande", "Dócil e brincalhão", R.drawable.placeholder));

        gridModelArrayList.add(new GridModel(6, "REX", "Golden Retriever",
                "21/03/2020", "7 anos", "Aguardando adoção",
                "Macho", "Grande", "Dócil e brincalhão", R.drawable.placeholder));
*/
/*
        gridModelArrayList.add(new GridModel("MAX", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("COOPER", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("KOBE", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("OAKLEY", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("OSCAR", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("MAC", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("RUDY", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("REX", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("BAILEY", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("TEDDY", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("CHARLIE", R.drawable.placeholder));
        gridModelArrayList.add(new GridModel("BEAR", R.drawable.placeholder));*/

        GridAdapter adapter = new GridAdapter(getContext(), gridModelArrayList);
        gridviewHome.setAdapter(adapter);

        gridviewHome.setOnItemClickListener(new GridView.OnItemClickListener(){
            @Override
            public void onItemClick(AdapterView parent, View view, int position, long id) {
                // TODO Auto-generated method stub
               // Toast.makeText(getContext(), "Imagem: "+(position+1), Toast.LENGTH_SHORT).show();

                MainActivity.pos = position + 1;
                Intent intent = new Intent();
                intent.setClass(getActivity(), activity_details.class);
                getActivity().startActivity(intent);

            }

        });
        // Inflate the layout for this fragment
        return view;
    }
}