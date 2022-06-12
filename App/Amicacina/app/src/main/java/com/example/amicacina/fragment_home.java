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

        ArrayList<GridModel> courseModelArrayList = new ArrayList<GridModel>();
        courseModelArrayList.add(new GridModel("DSA", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("JAVA", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("C++", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("Python", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("Javascript", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("DSA", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("DSA", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("JAVA", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("C++", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("Python", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("Javascript", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("DSA", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("DSA", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("JAVA", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("C++", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("Python", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("Javascript", R.drawable.placeholder));
        courseModelArrayList.add(new GridModel("DSA", R.drawable.placeholder));

        GridAdapter adapter = new GridAdapter(getContext(), courseModelArrayList);
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