package com.example.amicacina;

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
        gridModelArrayList.add(new GridModel("BEAR", R.drawable.placeholder));

        GridAdapter adapter = new GridAdapter(getContext(), gridModelArrayList);
        gridviewHome.setAdapter(adapter);

        gridviewHome.setOnItemClickListener(new GridView.OnItemClickListener(){
            @Override
            public void onItemClick(AdapterView parent, View view, int position, long id) {
                // TODO Auto-generated method stub
                Toast.makeText(getContext(), "Imagem: "+(position+1), Toast.LENGTH_SHORT).show();
            }

        });
        // Inflate the layout for this fragment
        return view;
    }
}