package com.example.amicacina;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.Toast;

import java.util.ArrayList;

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


        //MainActivity.foto[6] = String.valueOf(R.drawable.pinscher);

        MainActivity.id[0] = "0";
        MainActivity.id[1] = "1";
        MainActivity.id[2] = "2";
        MainActivity.id[3] = "3";
        MainActivity.id[4] = "4";
        MainActivity.id[5] = "5";
        MainActivity.id[6] = "6";

        MainActivity.nome[0] = "THOR";
        MainActivity.nome[1] = "NINA";
        MainActivity.nome[2] = "MAX";
        MainActivity.nome[3] = "FUSQUINHA";
        MainActivity.nome[4] = "PIPOCA";
        MainActivity.nome[5] = "LUNA";
        MainActivity.nome[6] = "REX";

        MainActivity.raca[0] = "SRD (Sem raça definida)";
        MainActivity.raca[1] = "Shih Tzu";
        MainActivity.raca[2] = "Golden retriever";
        MainActivity.raca[3] = "Dachshund";
        MainActivity.raca[4] = "Buldogue Frances";
        MainActivity.raca[5] = "Lulu da Pomerania";
        MainActivity.raca[6] = "Pinscher alemao";

        MainActivity.nasc[0] = "12/02/2020";
        MainActivity.nasc[1] = "12/02/2020";
        MainActivity.nasc[2] = "12/02/2020";
        MainActivity.nasc[3] = "12/02/2020";
        MainActivity.nasc[4] = "12/02/2020";
        MainActivity.nasc[5] = "12/02/2020";
        MainActivity.nasc[6] = "12/02/2020";

        MainActivity.idad[0] = "3 anos";
        MainActivity.idad[1] = "6 meses";
        MainActivity.idad[2] = "4 anos";
        MainActivity.idad[3] = "1 ano";
        MainActivity.idad[4] = "1 ano";
        MainActivity.idad[5] = "2 anos";
        MainActivity.idad[6] = "5 anos";

        MainActivity.stat[0] = "Aguardando adoção";
        MainActivity.stat[1] = "Aguardando adoção";
        MainActivity.stat[2] = "Aguardando adoção";
        MainActivity.stat[3] = "Aguardando adoção";
        MainActivity.stat[4] = "Aguardando adoção";
        MainActivity.stat[5] = "Aguardando adoção";
        MainActivity.stat[6] = "Aguardando adoção";

        MainActivity.gene[0] = "Macho";
        MainActivity.gene[1] = "Fêmea";
        MainActivity.gene[2] = "Macho";
        MainActivity.gene[3] = "Macho";
        MainActivity.gene[4] = "Macho";
        MainActivity.gene[5] = "Fêmea";
        MainActivity.gene[6] = "Macho";

        MainActivity.port[0] = "Médio";
        MainActivity.port[1] = "Pequeno";
        MainActivity.port[2] = "Grande";
        MainActivity.port[3] = "Pequeno";
        MainActivity.port[4] = "Pequeno";
        MainActivity.port[5] = "Pequeno";
        MainActivity.port[6] = "Grande";

        MainActivity.comp[0] = "Amigável e brincalhão";
        MainActivity.comp[1] = "Amigável e brincalhão";
        MainActivity.comp[2] = "Amigável e brincalhão";
        MainActivity.comp[3] = "Amigável e brincalhão";
        MainActivity.comp[4] = "Amigável e brincalhão";
        MainActivity.comp[5] = "Amigável e brincalhão";
        MainActivity.comp[6] = "Amigável e brincalhão";

        MainActivity.foto[0] = getResources().getIdentifier("viralata", "drawable", "com.example.amicacina");
        MainActivity.foto[1] = getResources().getIdentifier("shihtzu", "drawable", "com.example.amicacina");
        MainActivity.foto[2] = getResources().getIdentifier("goldenretriever", "drawable", "com.example.amicacina");
        MainActivity.foto[3] = getResources().getIdentifier("dachshund", "drawable", "com.example.amicacina");
        MainActivity.foto[4] = getResources().getIdentifier("buldogue_frances", "drawable", "com.example.amicacina");
        MainActivity.foto[5] = getResources().getIdentifier("luludapomerania", "drawable", "com.example.amicacina");
        MainActivity.foto[6] = getResources().getIdentifier("pinscher", "drawable", "com.example.amicacina");


        for(int i=0 ; i <= 6; i++){
            gridModelArrayList.add(new GridModel(MainActivity.id[i], MainActivity.nome[i], MainActivity.raca[i],
                    MainActivity.nasc[i], MainActivity.idad[i], MainActivity.stat[i],
                    MainActivity.gene[i], MainActivity.port[i], MainActivity.comp[i], MainActivity.foto[i]));

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