package com.example.amicacina;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.util.Log;
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
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class fragment_home extends Fragment {

    GridView gridviewHome;

    public fragment_home() {
        // Required empty public constructor
    }


    @Override

    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);

        gridviewHome = (GridView) view.findViewById(R.id.GridViewHome);
        //gridviewHome = findViewById(R.id.GridViewHome);

        ArrayList<GridModel> gridModelArrayList = new ArrayList<GridModel>();

        String url = "https://amicao.herokuapp.com/application_retrieve/pets";
        String url_count = "https://amicao.herokuapp.com/application_retrieve/pets";

        /*
        for(int i=0; i<result.size(); i++){
            JsonObject retx=result.get(i).getAsJsonObject();
            MainActivity.qnt_res = retx.get("count").getAsInt();

        }*/

                Ion.with (getActivity())
                .load (url_count )
                .asJsonArray()
                .setCallback ( new FutureCallback<JsonArray>() {
                    @Override
                    public void onCompleted(Exception e, JsonArray result) {
                        //for(int i=0; i<result.size(); i++){
                                JsonObject retx=result.get(0).getAsJsonObject();
                                Log.d("JOSN", retx.toString());
                                MainActivity.qnt_res = retx.get("count").getAsInt();
                        //}
                    }
                });


        Ion.with (getActivity())
                .load ( url )
                .asJsonArray()
                .setCallback ( new FutureCallback<JsonArray>() {
                    @Override
                    public void onCompleted(Exception e, JsonArray result) {

                        List<String> lista = new ArrayList<String>();

                        for(int i=0; i<result.size(); i++){
                            JsonObject retx=result.get( i ).getAsJsonObject();

                            lista.add(retx.get("id").getAsString().toString());
                            lista.add(retx.get("nome").getAsString().toString());
                            lista.add(retx.get("raca_pai").getAsString().toString());
                            lista.add(retx.get("raca_mae").getAsString().toString());
                            lista.add(retx.get("raca").getAsString().toString());
                            lista.add(retx.get("nascimento").getAsString().toString());
                            lista.add(retx.get("idade").getAsString().toString());
                            lista.add(retx.get("status").getAsString().toString());
                            lista.add(retx.get("comportamento").getAsString().toString());
                            lista.add(retx.get("genero").getAsString().toString());
                        }
                    }
                });

        for(int i=0 ; i <= MainActivity.qnt_res; i++){
            gridModelArrayList.add(new GridModel(MainActivity.id[i], MainActivity.nome[i], MainActivity.raca[i],
                    MainActivity.nasc[i], MainActivity.idad[i], MainActivity.stat[i],
                    MainActivity.gene[i], MainActivity.port[i], MainActivity.comp[i], MainActivity.foto[i]));

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