package com.example.amicacina;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.GridView;

import java.util.ArrayList;
import java.util.List;

public class fragment_fav extends Fragment {

    //public static List<String> favId;
    //public static int totalFav;
    GridView gridviewFav;

    //public static ArrayList<GridModel> gridModelArrayList;

    /*int totalFav = 0;
    int[] favId= new int[totalFav];*/

    public fragment_fav() {
        // Required empty public constructor
    }


    @Override

    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_fav, container, false);

        gridviewFav = (GridView) view.findViewById(R.id.GridViewFav);
        ArrayList<GridModel> gridModelArrayList = new ArrayList<GridModel>();
/*
        List<String> favId = new ArrayList<String>();
        favId.add("a");

        for(int i=0 ; i <= totalFav; i++){

            gridModelArrayList.add(new GridModel(MainActivity.id[i], MainActivity.nome[i], MainActivity.raca[i],
                    MainActivity.nasc[i], MainActivity.idad[i], MainActivity.stat[i],
                    MainActivity.gene[i], MainActivity.port[i], MainActivity.comp[i], MainActivity.foto[i]));

        }
*/
        GridAdapter adapter = new GridAdapter(getContext(), gridModelArrayList);
        gridviewFav.setAdapter(adapter);

        gridviewFav.setOnItemClickListener(new GridView.OnItemClickListener(){
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

        if (MainActivity.fav[0] == true) {
            gridModelArrayList.add(new GridModel(MainActivity.id[0], MainActivity.nome[0], MainActivity.raca[0],
                    MainActivity.nasc[0], MainActivity.idad[0], MainActivity.stat[0],
                    MainActivity.gene[0], MainActivity.port[0], MainActivity.comp[0], MainActivity.foto[0]));
        }

        if (MainActivity.fav[1] == true) {
            gridModelArrayList.add(new GridModel(MainActivity.id[1], MainActivity.nome[1], MainActivity.raca[1],
                    MainActivity.nasc[1], MainActivity.idad[1], MainActivity.stat[1],
                    MainActivity.gene[1], MainActivity.port[1], MainActivity.comp[1], MainActivity.foto[1]));
        }

        if (MainActivity.fav[2] == true) {
            gridModelArrayList.add(new GridModel(MainActivity.id[2], MainActivity.nome[2], MainActivity.raca[2],
                    MainActivity.nasc[2], MainActivity.idad[2], MainActivity.stat[2],
                    MainActivity.gene[2], MainActivity.port[2], MainActivity.comp[2], MainActivity.foto[2]));
        }

        if (MainActivity.fav[3] == true) {
            gridModelArrayList.add(new GridModel(MainActivity.id[3], MainActivity.nome[3], MainActivity.raca[3],
                    MainActivity.nasc[3], MainActivity.idad[3], MainActivity.stat[3],
                    MainActivity.gene[3], MainActivity.port[3], MainActivity.comp[3], MainActivity.foto[3]));
        }

        if (MainActivity.fav[4] == true) {
            gridModelArrayList.add(new GridModel(MainActivity.id[4], MainActivity.nome[4], MainActivity.raca[4],
                    MainActivity.nasc[4], MainActivity.idad[4], MainActivity.stat[4],
                    MainActivity.gene[4], MainActivity.port[4], MainActivity.comp[4], MainActivity.foto[4]));
        }

        if (MainActivity.fav[5] == true) {
            gridModelArrayList.add(new GridModel(MainActivity.id[5], MainActivity.nome[5], MainActivity.raca[5],
                    MainActivity.nasc[5], MainActivity.idad[5], MainActivity.stat[5],
                    MainActivity.gene[5], MainActivity.port[5], MainActivity.comp[5], MainActivity.foto[5]));
        }

        if (MainActivity.fav[6] == true) {
            gridModelArrayList.add(new GridModel(MainActivity.id[6], MainActivity.nome[6], MainActivity.raca[6],
                    MainActivity.nasc[6], MainActivity.idad[6], MainActivity.stat[6],
                    MainActivity.gene[6], MainActivity.port[6], MainActivity.comp[6], MainActivity.foto[6]));
        }
        // Inflate the layout for this fragment
        return view;
    }
}