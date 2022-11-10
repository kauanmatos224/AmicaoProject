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

    GridView gridviewFav;


    public fragment_fav() {
        // Required empty public constructor
    }


    @Override

    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_fav, container, false);

        gridviewFav = (GridView) view.findViewById(R.id.GridViewFav);
        ArrayList<GridModel> gridModelArrayList = new ArrayList<GridModel>();

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

        return view;
    }
}