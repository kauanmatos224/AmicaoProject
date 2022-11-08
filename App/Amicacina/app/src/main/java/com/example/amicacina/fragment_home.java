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

        GridAdapter adapter = new GridAdapter(getContext(), gridModelArrayList);
        gridviewHome.setAdapter(adapter);

        gridviewHome.setOnItemClickListener(new GridView.OnItemClickListener(){
            @Override
            public void onItemClick(AdapterView parent, View view, int position, long id) {
                // TODO Auto-generated method stub
               // Toast.makeText(getContext(), "Imagem: "+(position+1), Toast.LENGTH_SHORT).show();

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